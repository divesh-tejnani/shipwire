<?php
/*
	This code just displays the generated orders and the orders to be processed as of now.
	I had some questions on the solution for allocating the inventory.
*/
// Initial inventory
$inventory = array("A"=>15, "B"=>20, "C"=>22, "D"=>18, "E"=>30);
// number of orders to be generated
$numberOfOrders = 10;
///*

/*
	The below function generates orders as per the $numberOfOrders specified.
	The function randomly selects a product and creates an order with a random quantity between 0 and 6.
	Was getting unexpected results while using pthreads to create multiple data sources so created the below method
*/
function generateOrders($orderCount) 
{ 
	$count = 0;
    $order = array(); 
	echo "<br>------------ Genearated orders -------------------<br><br>";
		while($count <= $orderCount) {
			$products = array('A','B','C','D','E');
			// random number to generate the number of lines for an order
			$linesToBeGenerated = rand(1, 4);
			$temp = array();

			for ($i = 1; $i <= $linesToBeGenerated; $i++) {
				$letter = rand(0, count($products)-1);
				// select random product and assign random quantity to create a line for the order
				$temp[] = "". $products[$letter] . ":". rand(0, 6);
				// remove the product from the array to avoid duplicate lines for a product
				unset($products[$letter]);
				$products = array_values($products);
			}

			$order[] = $temp;
			echo "<br>Order # $count)  &nbsp &nbsp";
			//var_dump(!empty($temp));
			var_dump($temp);
			$count++;
		}
	echo "<br><br>------------ End of Genearated orders -------------------<br><br>";
    return $order; 
} 

$orders = generateOrders($numberOfOrders);
//$orders2 = generateOrders($numberOfOrders);
echo "<br>------------ Process orders -------------------<br><br>";
processOrders($orders);

//*/

/*
	The below function would take the generated orders as parameters and process each line of the order.
*/
function processOrders($orders) 
{
	$arrlength = count($orders);
	for($x = 0; $x < $arrlength; $x++) {
		$temp = $orders[$x];
		$templength = count($temp);
		echo "<br>#### Order # $x #####";
		
		for($i = 0; $i < $templength; $i++) {
			$productOrder = $temp[$i];
			$line = array();
			echo "<br>Line # $i &nbsp".$productOrder;
			$line = explode(":",$productOrder);
			$quantity =  (int) $line[1];
			//var_dump($inventory);
		}
		echo "<br>";
	}
}



/*
Commented out the below code as was having some problems with pthreads
*/
/*

class WorkerThreads extends Thread
{
    public $workerId;
	public $ordersGenerated;
	public $order;
 
    public function __construct($id, $orders)
    {
        $this->workerId = $id;
        $this->ordersGenerated = $orders;
		$this->order = array();
    }
 
    public function run()
    {
		$i = 0;
		//while($i < $orders) {
			sleep(rand(0, 3));
			$this->ordersGenerated = rand(0, 3);
			$this->order[] = array(0 => array("A"=>10, "B"=>10, "C"=>10, "D"=>10, "E"=>10));
			$this->order[] = array(1 => array("A"=>10, "B"=>10, "C"=>10));

			echo "{var_dump($order)} Worker {$this->workerId} ran <br>" . PHP_EOL;
			//$i++;
		//}
    }
}
// var_dump($inventory);
// Worker pool
$workers = [];
 
// Initialize and start the threads
foreach (range(1, 2) as $i) {
    $workers[$i] = new WorkerThreads($i,10);
    $workers[$i]->start();
}
 
// Let the threads come back
foreach (range(1, 2) as $i) {
    	$workers[$i]->join();
}
var_dump($workers[1]->ordersGenerated);
var_dump($workers[1]->order);
//var_dump($inventory1[0]);
*/


?>
