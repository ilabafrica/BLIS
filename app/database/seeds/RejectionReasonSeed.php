<?php
class RejectionReasonSeed extends KBLISSeeder
{
	public static function get()
	{
		return array( 
          array("reason" => "Poorly labelled"),
          array("reason" => "Over saturation"),
          array("reason" => "Insufficient Sample"),
          array("reason" => "Scattered"),
          array("reason" => "Clotted Blood"),
          array("reason" => "Two layered spots"),
          array("reason" => "Serum rings"),
          array("reason" => "Scratched"),
          array("reason" => "Haemolysis"),
          array("reason" => "Spots that cannot elute"),
          array("reason" => "Leaking"),
          array("reason" => "Broken Sample Container"),
          array("reason" => "Mismatched sample and form labelling"),
          array("reason" => "Missing Labels on container and tracking form"),
          array("reason" => "Empty Container"),
          array("reason" => "Samples without tracking forms"),
          array("reason" => "Poor transport"),
          array("reason" => "Lipaemic"),
          array("reason" => "Wrong container/Anticoagulant"),
          array("reason" => "Request form without samples"),
          array("reason" => "Missing collection date on specimen / request form."),
          array("reason" => "Name and signature of requester missing"),
          array("reason" => "Mismatched information on request form and specimen container."),
          array("reason" => "Request form contaminated with specimen"),
          array("reason" => "Duplicate specimen received"),
          array("reason" => "Delay between specimen collection and arrival in the laboratory"),
          array("reason" => "Inappropriate specimen packing"),
          array("reason" => "Inappropriate specimen for the test"),
          array("reason" => "Inappropriate test for the clinical condition"),
          array("reason" => "No Label"),
          array("reason" => "Leaking"),
          array("reason" => "No Sample in the Container"),
          array("reason" => "No Request Form"),
          array("reason" => "Missing Information Required")
		);
	}
}