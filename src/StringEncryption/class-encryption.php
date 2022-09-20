<?php
/**
 * Encrypt and Decrypt String.
 *
 * @category Encryption
 * @package  StringEncryption
 * @author   Donovan Maidens
 */

namespace StringEncryption;

/**
 * Encrypt and Decrypt String Class.
 *
 * @category Class
 * @package  Encryption
 * @author   Donovan Maidens
 */
class Encryption {

	/**
	 * The key used to dencrypt and decrypt strings.
	 *
	 * @var string
	 */
	private static $encrytion_key = 'gdWEGLSzcdyXeNyLSakqsypt';

	/**
	 * The encrytyption type used to encrypt strings.
	 *
	 * @var string
	 */
	private static $encrytion_type = 'AES-128-CBC';

	/**
	 * A wrapper method to protect base64 encode.
	 *
	 * @param string $string the string to be encoded.
	 * @return string
	 */
	private static function safe_b64encode( $string ) {
		// @codingStandardsIgnoreStart
		$data = base64_encode( $string );
		// @codingStandardsIgnoreEnd
		$data = str_replace( array( '+', '/', '=' ), array( '-', '_', '' ), $data );

		return $data;
	}

	/**
	 * A wrapper to protect base64 decode,
	 *
	 * @param string $string the string to be decoded.
	 * @return string
	 */
	private static function safe_b64decode( $string ) {
		$data = str_replace( array( '-', '_' ), array( '+', '/' ), $string );
		$mod4 = strlen( $data ) % 4;
		if ( $mod4 ) {
			$data .= substr( '====', $mod4 );
		}
		// @codingStandardsIgnoreStart
		return base64_decode( $data );
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Encryption method to encrypt a string.
	 *
	 * @param string $data the string to be encrytpted.
	 * @return string
	 */
	public static function encrypt( $data ) {
		if ( ! $data ) {
			return false;
		}

		$key            = self::$encrytion_key;
		$cipher         = self::$encrytion_type;
		$plaintext      = $data;
		$ivlen          = openssl_cipher_iv_length( $cipher );
		$iv             = openssl_random_pseudo_bytes( $ivlen );
		$ciphertext_raw = openssl_encrypt( $plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv );
		$hmac           = hash_hmac( 'sha256', $ciphertext_raw, $key, $as_binary = true );
		$ciphertext     = self::safe_b64encode( $iv . $hmac . $ciphertext_raw );

		return $ciphertext;
	}

	/**
	 * Decrypting an encrytpted string.
	 *
	 * @param string $data the encrypted string that needs to be decripted.
	 * @return string
	 */
	public static function decrypt( $data ) {
		if ( ! $data ) {
			return false;
		}

		$key                = self::$encrytion_key;
		$cipher             = self::$encrytion_type;
		$c                  = self::safe_b64decode( $data );
		$ivlen              = openssl_cipher_iv_length( $cipher );
		$iv                 = substr( $c, 0, $ivlen );
		$hmac               = substr( $c, $ivlen, $sha2len = 32 );
		$ciphertext_raw     = substr( $c, $ivlen + $sha2len );
		$original_plaintext = openssl_decrypt( $ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv );
		$calcmac            = hash_hmac( 'sha256', $ciphertext_raw, $key, $as_binary = true );

		if ( hash_equals( $hmac, $calcmac ) ) {
			return $original_plaintext;
		}
	}
}
