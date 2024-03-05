<?php
function runFeeAlgo($monthIndex,$allMonths,$studentSession,$admno,$conn,$t1,$route)
        {
            echo "Month applicable" . $allMonths[$monthIndex - 1];
            $feeQuery = "select fee,type from fees where class in ('ALL',(select class from $studentSession where admno=$admno))
    and months_applicable in ($monthIndex,'ALL')";
            //echo $feeQuery;
            $cumulativeFee = mysqli_query($conn, $feeQuery);
            echo "</br>";
            while ($each = mysqli_fetch_array($cumulativeFee))
            {
                $feeTitle = $each[1];
                $feeValue = $each[0];
                echo $feeTitle . " : " . $feeValue;
                echo "</br>";
                $t1 += $feeValue;
            }
            $tranf = mysqli_query(
                $conn,
                "select rfee from transport where id=$route"
            );
            $tranf1 = $tranf->fetch_assoc();
            $tranf1 = $tranf1["rfee"];
            $tranf2 = $tranf1;
            $t1 += $tranf2;
            echo "Transport Fee: " . $tranf2;
            echo "</br>";
            echo "</br>";
            $monthIndex++;
        }
?>