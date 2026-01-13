<?php
declare( strict_types=1 );

namespace MediaWiki\Extension\CacheBuster;

use LocalRepo;

/**
 * Extended LocalRepo that uses CacheBusterLocalFile for cache-busted file URLs
 */
class CacheBusterLocalRepo extends LocalRepo {

	/**
	 * Initialize the repository with cache-busted file factory methods
	 *
	 * @param array|null $info Repository configuration
	 */
	public function __construct( ?array $info = null ) {
		// Configure factory methods to use our cache-busted file class
		$this->fileFactory = [ CacheBusterLocalFile::class, 'newFromTitle' ];
		$this->fileFactoryKey = [ CacheBusterLocalFile::class, 'newFromKey' ];
		$this->fileFromRowFactory = [ CacheBusterLocalFile::class, 'newFromRow' ];
		
		parent::__construct( $info );
	}
}
