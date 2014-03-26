<?php
namespace app\controllers;
use app\extensions\action\Coingreen;
use app\models\Blocks;
use MongoDate;

class QController extends \lithium\action\Controller {
	public function index(){
		return "index";
	}
	public function hr24price(){
	$this->_render['layout'] = false;	
			return "0.01";
	}
	public function hr24transactioncount(){
		$coingreen = new COINGREEN('http://'.COINGREEN_WALLET_SERVER.':'.COINGREEN_WALLET_PORT,COINGREEN_WALLET_USERNAME,COINGREEN_WALLET_PASSWORD);
		$EndDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24)));

	$txCount = Blocks::find('count',array(
		'conditions'=>array('time'=>array('$gte'=>$EndDate))
	));
	$this->_render['layout'] = false;
	return compact('txCount');

	}
	
	public function hr24xgcsent(){
		$EndDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24)));
	$txs= Blocks::find('all',array(
		'conditions'=>array('time'=>array('$gte'=>$EndDate))
	));
	$amount = 0;
	$this->_render['layout'] = false;
	foreach($txs as $tx){
		foreach($tx['txid'] as $txid){
			if($txid['vout']!=""){
				foreach($txid['vout'] as $vout){
					$amount = $amount + $vout['value'];
				}
			}
		}
	}
	return compact('amount');
	}
	public function hashrate(){
		$coingreen = new COINGREEN('http://'.COINGREEN_WALLET_SERVER.':'.COINGREEN_WALLET_PORT,COINGREEN_WALLET_USERNAME,COINGREEN_WALLET_PASSWORD);
		$getinfo = $coingreen->getinfo();
		return (string)($getinfo['difficulty']);
	}
	public function totalbc(){
		$coingreen = new COINGREEN('http://'.COINGREEN_WALLET_SERVER.':'.COINGREEN_WALLET_PORT,COINGREEN_WALLET_USERNAME,COINGREEN_WALLET_PASSWORD);
		$getinfo = $coingreen->getinfo();
		return (string)($getinfo['blocks']*5000*100000)."";
	}
	public function marketcap(){
		$coingreen = new COINGREEN('http://'.COINGREEN_WALLET_SERVER.':'.COINGREEN_WALLET_PORT,COINGREEN_WALLET_USERNAME,COINGREEN_WALLET_PASSWORD);
		$getinfo = $coingreen->getinfo();
		return (string)($getinfo['blocks']*5000*1000*.01);

	}
	public function addressbalance($address = null){
		$txs = Blocks::find('all',array(
			'conditions'=>array('txid.vout.scriptPubKey.addresses'=>$address),
//			'fields'=>array('txid.vout.scriptPubKey.addresses','height','txid.vout.value')
		));
	$amount = 0;
	$this->_render['layout'] = false;
	foreach($txs as $tx){
		foreach($tx['txid'] as $txid){
			if(!$txid['vin']['coinbase']){
				if($txid['vout']!=""){
					foreach($txid['vout'] as $vout){
						$amount = $amount + $vout['value'];
					}
				}
			}
		}
	}
	return compact('amount');

	}
} // class
?>