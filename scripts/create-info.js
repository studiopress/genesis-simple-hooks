const fs = require('fs');
const path = require('path');
const https = require('https');
const Ajv = require('ajv');
const { execSync } = require('child_process');

// For schema validation
const ajv = new Ajv({strict: false});

// Read version from plugin.php
const pluginFile = fs.readFileSync(path.join(__dirname, '..', 'plugin.php'), 'utf8');
const versionMatch = pluginFile.match(/Version:\s*(.+)/);
const currentVersion = versionMatch ? versionMatch[1].trim() : null;

if (!currentVersion) {
    console.error('Error: Could not find version in plugin.php');
    process.exit(1);
}

// Validate version format (x.x.x)
if (!/^\d+\.\d+\.\d+$/.test(currentVersion)) {
    console.error('Error: Version must be in the format x.x.x');
    process.exit(1);
}

// Read readme.txt for version requirements and changelog
const readmeContent = fs.readFileSync(path.join(__dirname, '..', 'readme.txt'), 'utf8');

// Extract version requirements from readme.txt
const requiresMatch = readmeContent.match(/Requires at least: ([\d.]+)/);
const testedMatch = readmeContent.match(/Tested up to: ([\d.]+)/);
const requiresPhpMatch = readmeContent.match(/Requires PHP: ([\d.]+)/);

if (!requiresMatch || !testedMatch) {
    console.error('Error: Could not find all required version information in readme.txt');
    console.error('Required: ' + (requiresMatch ? '✓' : '✗'));
    console.error('Tested: ' + (testedMatch ? '✓' : '✗'));
    process.exit(1);
}

// Extract changelog section
const changelogMatch = readmeContent.match(/== Changelog ==\n\n([\s\S]*?)(?=\n\n==|$)/);
let changelogHtml = '';
if (changelogMatch) {
    changelogHtml = changelogMatch[1]
        .replace(/= (.*?) =\n/g, '<h4>$1</h4>\n')
        .replace(/\n/g, '<br />\n');
} else {
    console.error('Warning: Could not find changelog section in readme.txt');
}

// Read schema for validation
const schema = JSON.parse(fs.readFileSync(path.join(__dirname, 'info-json-schema.json'), 'utf8'));

// Pre-compile the validation function
const validate = ajv.compile(schema);

function fetchJson(url) {
    return new Promise((resolve, reject) => {
        console.log(`Fetching ${url}...`);
        const req = https.get(url, (res) => {
            if (res.statusCode !== 200) {
                reject(new Error(`HTTP ${res.statusCode}: ${res.statusMessage}`));
                return;
            }

            let data = '';
            res.on('data', (chunk) => data += chunk);
            res.on('end', () => {
                try {
                    const json = JSON.parse(data);
                    resolve(json);
                } catch (error) {
                    reject(new Error('Invalid JSON response: ' + error.message));
                }
            });
        });

        req.on('error', reject);
        req.setTimeout(10000, () => {
            req.destroy();
            reject(new Error('Request timed out'));
        });
    });
}

function formatDate(date) {
    // Format: YYYY-MM-DD HH:mm:ss GMT
    return date.toISOString().replace('T', ' ').replace(/\.\d{3}Z$/, ' GMT');
}

function showDiff(downloadedInfo, writtenInfo, outputPath) {
    const tempPath = outputPath + '.old';
    fs.writeFileSync(tempPath, JSON.stringify(downloadedInfo, null, 2));
    try {
        const diff = execSync(`git diff --no-index "${tempPath}" "${outputPath}"`).toString();
        if (diff) {
            console.log('\nChanges made to info.json:');
            console.log(diff);
        } else {
            console.log('\nWarning: No changes detected in info.json');
            console.log('Did you remember to bump the plugin version in plugin.php?');
        }
    } catch (error) {
        // git diff returns exit code 1 if there are differences,
        // which causes execSync to throw
        if (error.stdout) {
            console.log('\nChanges made to info.json:');
            console.log(error.stdout.toString());
        }
    } finally {
        fs.unlinkSync(tempPath);
    }
}

async function createInfoJson() {
    try {
        console.log('Current version:', currentVersion);
        console.log('WordPress version requirements:');
        console.log('- Requires at least:', requiresMatch[1]);
        console.log('- Tested up to:', testedMatch[1]);
        if (requiresPhpMatch) {
            console.log('- Requires PHP:', requiresPhpMatch[1]);
        }

        // Fetch current info.json
        const info = await fetchJson('https://wpe-plugin-updates.wpengine.com/genesis-simple-hooks/info.json');
        console.log('Successfully fetched current info.json');

        // Update required fields
        info.version = currentVersion;
        info.download_link = info.download_link.replace(/genesis-simple-hooks\.\d+\.\d+\.\d+\.zip/, `genesis-simple-hooks.${currentVersion}.zip`);
        info.versions[currentVersion] = info.download_link;
        info.last_updated = formatDate(new Date());

        // Update version requirements
        info.requires = requiresMatch[1];
        info.tested = testedMatch[1];
        if (requiresPhpMatch) {
            info.requires_php = requiresPhpMatch[1];
        }

        // Update changelog
        info.sections.changelog = changelogHtml;

        // Ensure required sections exist
        info.sections.screenshots = info.sections.screenshots || '';
        info.sections.reviews = info.sections.reviews || '';

        // Ensure top-level fields have the correct types
        if (!info.screenshots || typeof info.screenshots !== 'object' || Array.isArray(info.screenshots)) {
            info.screenshots = {};
        }

        // Create build/wpe directory if it doesn't exist
        const buildDir = path.join(__dirname, '..', 'build', 'wpe');
        if (!fs.existsSync(buildDir)) {
            fs.mkdirSync(buildDir, { recursive: true });
        }

        // Write the updated info.json
        const outputPath = path.join(buildDir, 'info.json');
        fs.writeFileSync(outputPath, JSON.stringify(info, null, 2));

        // Read back the file and validate it
        const writtenInfo = JSON.parse(fs.readFileSync(outputPath, 'utf8'));
        const isValid = validate(writtenInfo);
        if (!isValid) {
            console.error('Validation failed. The following errors were found:');
            validate.errors.forEach((error) => {
                console.error(`- ${error.instancePath}: ${error.message}`);
            });
            process.exit(1);
        }
        console.log('Successfully created info.json at', outputPath);
        console.log('New info.json passed validation');

        // Show git diff between downloaded and new JSON
        showDiff(await fetchJson('https://wpe-plugin-updates.wpengine.com/genesis-simple-hooks/info.json'), writtenInfo, outputPath);
    } catch (error) {
        console.error('Error creating info.json:', error.message);
        process.exit(1);
    }
}

createInfoJson();
