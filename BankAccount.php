<?php
abstract class BankAccount{
	const INFO="Constant in BankAccount class<br /><br />";
	static public $stat="static property string<br /><br />";
	protected $Balance=0;
	public $APR;
	private $AccountNumber;
	public $SortCode;
	public $FirstName;
	public $LastName;
	public $Audit=array();
	protected $Locked=false;
	
	//Constructor
	public function __construct($apr, $sc, $fn, $ln, $bal=0, $lock=false){
		$this->Balance=$bal;
		$this->APR=$apr;
		$this->SortCode=$sc;
		$this->FirstName=$fn;
		$this->LastName=$ln;
		$this->Locked=$lock;
	}
	
	//Methods
	static public function stat(){
		echo "This is the method static string".self::INFO.self::$stat;
	}
	public function WithDraw($amount){
		$transDate=new DateTime();	//date of function invoke (WithDraw)
		if($this->Locked===false){
			$this->Balance-=$amount;
			array_push($this->Audit,array("WITHDRAW ACCEPTED", $amount, $this->Balance, $transDate->format('c')));
		}
		else{
			array_push($this->Audit,array("WITHDRAW DENIED", $amount, $this->Balance, $transDate->format('c')));
		}
	}
	public function Deposit($amount){
		$transDate=new DateTime();	//date of function invoke (Deposit)
		if($this->Locked===false){
			$this->Balance+=$amount;
			array_push($this->Audit,array("DEPOSIT ACCEPTED", $amount, $this->Balance, $transDate->format('c')));
		}
		else{
			array_push($this->Audit,array("DEPOSIT DENIED", $amount, $this->Balance, $transDate->format('c')));
		}
	}
	public function Lock(){
		$this->Locked=true;
		$lockedDate=new DateTime();
		array_push($this->Audit,array("Account Locked", $lockedDate->format('c')));
	}
	public function Unlock(){
		$this->Locked=false;
		$unlockedDate=new DateTime();
		array_push($this->Audit,array("Account Unlocked", $unlockedDate->format('c')));
	}
}
//echo BankAccount::INFO;
//echo BankAccount::$stat;
//echo BankAccount::stat();
?>