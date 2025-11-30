# Envato Elements Downloader

A simple PHP script for downloading assets from **Envato Elements** using a valid `cookies.txt` file exported from your Envato account. Once you provide the URL of an Envato Element, this script fetches the direct download URL for the content and retrieves the associated license information.

## Features
- Download assets from Envato Elements using your Envato account.
- Automatically saves the asset's license information in a separate file.
- Works with any Envato Elements content URL.
- Requires a valid `cookies.txt` file for authentication.

## Requirements
1. PHP installed on your server.
2. Export your cookies from Envato using the **[Cookie Exporter](https://github.com/realSina/cookie-exporter)** tool.
3. A valid Envato Elements account.

## How to Use

### 1. Export Your Cookies

To authenticate with your Envato account, you must export your cookies:

- Install the **[Cookie Exporter](https://github.com/realSina/cookie-exporter)** extension for your browser.
- Log in to your Envato account and export the cookies to a `cookies.txt` file.

### 2. Clone the Repository

Clone or download the repository and place it on your web server.

### 3. Update the Script

In the script file, update the following variables in line 26:
- **projectName**: Change this to the name of your project.
- **searchCorrelationId**: Update this with a unique ID for your search correlation.

### 4. Call the Script

You can call the script via URL like so: http://yourserver.com/envato-downloader.php?url=<envato_elements_asset_url>

The script will return a JSON response with the download URL and license information for the requested Envato asset.

## License

MIT License. See the [LICENSE](LICENSE) file for details.

## Disclaimer

Ensure you comply with Envato's terms of service and copyright policies. This script is intended for personal use only.
