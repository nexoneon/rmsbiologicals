<?php
// export_to_html.php
// This script converts your PHP project into a static HTML site for GitHub Pages.

require_once 'config.php';

// List of pages to export
$pages = [
    'index.php' => 'index.html',
    'about.php' => 'about.html',
    'products.php' => 'products.html',
    'categories.php' => 'categories.html', // If you have this
    'blog.php' => 'blog.html',
    'gallery.php' => 'gallery.html',
    'contact.php' => 'contact.html',
    'product_detail.php' => 'product_detail.html' // Note: This normally requires an ID, we might skip or hardcode a demo
];

echo "Starting Static Site Export...\n";
echo "-------------------------------\n";

foreach ($pages as $phpFile => $htmlFile) {
    if (!file_exists($phpFile)) {
        echo "Skipping $phpFile (File not found)\n";
        continue;
    }

    echo "Converting $phpFile -> $htmlFile ... ";

    // Start capturing output
    ob_start();

    // Include the file
    // We mock certain GET parameters to avoid errors if the page expects them
    $_GET['id'] = 1; // Default to ID 1 for detail pages
    $_SERVER['REQUEST_URI'] = '/' . $phpFile;
    
    include $phpFile;

    // Get content
    $content = ob_get_clean();

    // Fix Links: Replace .php extensions with .html for the static site
    $content = str_replace(
        ['index.php', 'about.php', 'products.php', 'categories.php', 'blog.php', 'gallery.php', 'contact.php'],
        ['index.html', 'about.html', 'products.html', 'categories.html', 'blog.html', 'gallery.html', 'contact.html'],
        $content
    );

    // Save to HTML file
    file_put_contents($htmlFile, $content);

    echo "DONE\n";
}

echo "-------------------------------\n";
echo "Export Complete! You can now commit and push the .html files to GitHub.\n";
