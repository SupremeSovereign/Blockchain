<?php
namespace app\controllers;
use app\extensions\action\coingreen;

class QController extends \lithium\action\Controller {
	public function index(){
		return "index";
	}
	public function hr24price(){
			return ".001";
	}
	public function hr24transactioncount(){
		return "222";
	}
	
	public function hr24btcsent(){
		return "333";
	}
	public function hashrate(){
		$coingreen = new COINGREEN('http://'.COINGREEN_WALLET_SERVER.':'.COINGREEN_WALLET_PORT,COINGREEN_WALLET_USERNAME,COINGREEN_WALLET_PASSWORD);
		$getinfo = $coingreen->getinfo();
		return (string)($getinfo['blocks']*5000*1000000);
	}
	public function totalbc(){
		$coingreen = new COINGREEN('http://'.COINGREEN_WALLET_SERVER.':'.COINGREEN_WALLET_PORT,COINGREEN_WALLET_USERNAME,COINGREEN_WALLET_PASSWORD);
		$getinfo = $coingreen->getinfo();
		return (string)($getinfo['blocks']*5000*1000000);
	}
	public function marketcap(){
		$coingreen = new COINGREEN('http://'.COINGREEN_WALLET_SERVER.':'.COINGREEN_WALLET_PORT,COINGREEN_WALLET_USERNAME,COINGREEN_WALLET_PASSWORD);
		$getinfo = $coingreen->getinfo();
		return (string)($getinfo['blocks']*5000*1000000*.001);

	}
	public function addressbalance(){
	return "777";
	}
} // class
?>