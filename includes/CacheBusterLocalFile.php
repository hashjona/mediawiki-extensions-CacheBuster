<?php
declare( strict_types=1 );

namespace MediaWiki\Extension\CacheBuster;

use LocalFile;

/**
 * Extended LocalFile that appends cache-busting query parameter to all URLs
 */
class CacheBusterLocalFile extends LocalFile {

	/**
	 * Append cache-busting parameter to a URL
	 *
	 * @param string $url Base URL
	 * @return string URL with ?cb=TIMESTAMP appended, or original URL if no timestamp
	 */
	private function appendCacheBuster( string $url ): string {
		$ts = $this->getTimestamp();
		if ( !$ts ) {
			// No timestamp available, return URL unchanged
			return $url;
		}
		$sep = ( strpos( $url, '?' ) === false ) ? '?' : '&';
		return $url . $sep . 'cb=' . rawurlencode( $ts );
	}

	/**
	 * Get the URL of the file
	 *
	 * @return string File URL with cache-busting parameter
	 */
	public function getUrl(): string {
		$url = parent::getUrl();
		return $this->appendCacheBuster( $url );
	}

	/**
	 * Get the full URL of the file
	 *
	 * @return string Full file URL with cache-busting parameter
	 */
	public function getFullUrl(): string {
		$url = parent::getFullUrl();
		return $this->appendCacheBuster( $url );
	}

	/**
	 * Get the URL of the thumbnail
	 *
	 * @param string|int|array $suffix Thumbnail suffix or parameters
	 * @return string|false Thumbnail URL with cache-busting parameter, or false on failure
	 */
	public function getThumbUrl( $suffix = '' ) {
		$url = parent::getThumbUrl( $suffix );
		if ( $url === false ) {
			return false;
		}
		return $this->appendCacheBuster( $url );
	}

	/**
	 * Get the full URL of the thumbnail
	 *
	 * @param string|int|array $suffix Thumbnail suffix or parameters
	 * @return string|false Full thumbnail URL with cache-busting parameter, or false on failure
	 */
	public function getThumbFullUrl( $suffix = '' ) {
		$url = parent::getThumbFullUrl( $suffix );
		if ( $url === false ) {
			return false;
		}
		return $this->appendCacheBuster( $url );
	}
}
