# MediaWiki Cache Busting Extension

Automatic cache-busting extension that appends timestamp-based query parameters to all file URLs, ensuring browsers fetch fresh versions when files are updated.

## Features

- Automatic cache-busting based on file modification times
- Uses `?cb=YYYYMMDDHHMMSS` format (e.g., `?cb=20250101121259`)
- Works with all file URLs (images, thumbnails, etc.)
- Low server load with efficient caching
- Updates automatically when files are modified

## How It Works

The extension extends MediaWiki's `LocalFile` and `LocalRepo` classes to:
1. Override URL-generating methods (`getUrl()`, `getFullUrl()`, `getThumbUrl()`, etc.)
2. Append `?cb={timestamp}` to all file URLs using the file's timestamp
3. Automatically update the cache-busting parameter whenever files are modified

## Install

1) Copy to `extensions/CacheBuster`
2) Add to `LocalSettings.php`:

```php
wfLoadExtension( 'CacheBuster' );
$wgLocalFileRepo['class'] = 'MediaWiki\\Extension\\CacheBuster\\CacheBusterLocalRepo';
```

**Note:** If you already have a `$wgLocalFileRepo` configuration, you only need to add or modify the `'class'` parameter. The extension will use your existing repository settings (directory, URL, etc.) but with cache-busted file URLs.

## Example

When a file is accessed, the URL will include the cache-busting parameter:

```
/w/images/example.jpg?cb=20250101121259
/w/images/thumb/example.jpg/300px-example.jpg?cb=20250101121259
```

The `cb` parameter will automatically update whenever the file is modified, ensuring users always get the latest version.

## Credits

This extension was inspired by [WikiDexFileRepository](https://github.com/ciencia/mediawiki-extensions-WikiDexFileRepository), which solves a similar cache-busting problem using path-based versioning. This extension takes a different approach by using query parameters instead, making it simpler to implement without requiring web server rewrite rules.
