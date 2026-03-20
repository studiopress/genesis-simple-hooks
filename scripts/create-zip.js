const fs = require("fs");
const path = require("path");
const AdmZip = require("adm-zip");
const { minimatch } = require("minimatch");
const { execSync } = require("child_process");

function getPluginVersion() {
	const pluginFile = fs.readFileSync("plugin.php", "utf8");
	const versionMatch = pluginFile.match(/Version:\s*(.+)/);
	return versionMatch ? versionMatch[1].trim() : "unknown";
}

function copyPluginUpdater() {
	const sourcePath = path.join(process.cwd(), 'scripts', 'class-genesis-simple-hooks-plugin-updater.php');
	const targetPath = path.join(process.cwd(), 'includes', 'class-genesis-simple-hooks-plugin-updater.php');
	fs.copyFileSync(sourcePath, targetPath);
	console.log('Copied class-genesis-simple-hooks-plugin-updater.php to includes directory');
}

function cleanupPluginUpdater() {
	const targetPath = path.join(process.cwd(), 'includes', 'class-genesis-simple-hooks-plugin-updater.php');
	if (fs.existsSync(targetPath)) {
		fs.unlinkSync(targetPath);
		console.log('Cleaned up class-genesis-simple-hooks-plugin-updater.php from includes directory');
	}
}

function ensureBuildDirectory(wpe = false) {
	const buildDir = path.join(process.cwd(), 'build', wpe ? 'wpe' : 'wp.org');
	if (!fs.existsSync(buildDir)) {
		fs.mkdirSync(buildDir, { recursive: true });
	}
	return buildDir;
}

function getIgnorePatterns() {
	const distignore = fs.readFileSync(".svnignore", "utf8");
	return distignore
		.split("\n")
		.map((line) => line.trim())
		.filter((line) => line && !line.startsWith("#"))
		.map((pattern) => `*${pattern}*`);
}

function shouldIgnore(filePath, ignorePatterns) {
	const relativePath = path.relative(process.cwd(), filePath);
	return ignorePatterns.some((pattern) =>
		minimatch(relativePath, pattern, { matchBase: true, dot: true })
	);
}

function runBuildSteps() {
	console.log("Running build steps...");

	try {
		console.log("Generating language file...");
		execSync(
            "wp i18n make-pot . languages/genesis-simple-hooks.pot --exclude=config,node_modules,scripts,vendor --headers='{ \"Report-Msgid-Bugs-To\": \"StudioPress <translations@studiopress.com>\" }' --exclude=bin/ --quiet",
			{ stdio: "inherit" }
		);
		console.log("Build steps completed successfully.");
	} catch (error) {
		console.error("Error during build steps:", error);
		process.exit(1);
	}
}

function createZip(wpe = false) {
	runBuildSteps();

	if (wpe) {
		copyPluginUpdater();
	}

	const version = getPluginVersion();
	const ignorePatterns = getIgnorePatterns();
	const buildDir = ensureBuildDirectory(wpe);
	const zipFileName = path.join(buildDir, `genesis-simple-hooks.${version}.zip`);

	const zip = new AdmZip();

	function addDirectoryToZip(directory) {
		const files = fs.readdirSync(directory);
		for (const file of files) {
			const filePath = path.join(directory, file);
			const stats = fs.statSync(filePath);
			const relativePath = path.relative(process.cwd(), filePath);

			if (shouldIgnore(filePath, ignorePatterns)) {
				continue;
			}

			if (stats.isDirectory()) {
				addDirectoryToZip(filePath);
			} else {
				zip.addFile(
					path.join("genesis-simple-hooks", relativePath),
					fs.readFileSync(filePath)
				);
			}
		}
	}

	addDirectoryToZip(process.cwd());

	zip.writeZip(zipFileName);
	console.log(`Created ${zipFileName}`);

	if (wpe) {
		cleanupPluginUpdater();
	}
}

const wpeFlag = process.argv.includes('--wpe');
createZip(wpeFlag);
