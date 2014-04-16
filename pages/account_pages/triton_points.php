<?php

$transactions = $users->getAllTransactions($users->user_id);
$total_tp = 0;
$transaction_table = "";

//Build the Transaction HTML Table
if($transactions) {
	//List the Transactions
	foreach($transactions as $transaction) {
		$sign = " + ";
		$total_tp += $transaction['value'];
		if($transaction['value'] < 0) {
			$sign = " - ";
			$transaction['value'] = -$transaction['value'];
		}
		$transaction_table = $transaction_table .
			"<div class='transaction'> 
				<div class='amount'>({$sign}) {$transaction['value']} Triton Points</div>
				<div class='comment'>{$transaction['comment']} </div>
			</div>";
	}
}


?>

<div id='transaction_list'>
	<?php
	//Place the Header
	echo "<div class='transaction' style='background: #144172;'>
					<div class='amount'>Amount: {$total_tp} TP</div>
					<div class='comment' style='background: #144172;'>Reason</div>
				</div>";

	if($transactions) {
		//List the Transactions
		echo $transaction_table;
	}
	//No Transactions...
	else {
		echo "<div class='transaction'>
						<div class='amount'>You have no Triton Point history.</div>
					</div>";
	}

	?>
</div>

<div id="purchase_history">
	<div class='transaction' style='background: #144172;'> 
		<div class='amount'>Purchase</div>
		<div class='comment' style='background: #144172;'>Status</div>
	</div>
	<div class='transaction'>
		<div class='amount'>You have no purchase history.</div>
	</div>
</div>