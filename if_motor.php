<?php

$service1 = 'Ganti Oli Mesin + Cek kampas Rem';
$service2 = 'Servis';


	if($kilometer_akhir >= 2500 AND $kilometer_akhir < 10000)
	{
		if($kilometer_akhir >= 2500 AND $kilometer_akhir < 5000 AND $km_serv !='2500')
		{
			$description =$service1."<br>";
			$km_service  = 2500;
		}
		elseif($kilometer_akhir >= 5000 AND $kilometer_akhir < 7500 AND $km_serv !='5000')
		{
			$description =$service1."<br>";
			$km_service   = 5000;
		
		elseif($kilometer_akhir >= 7500 AND $kilometer_akhir < 10000 AND $km_serv !='7500')
		{
			$description =$service1."<br>";
			$km_service   = 7500;
		}
					    		
	}
	elseif($kilometer_akhir >= 10000  AND $kilometer_akhir < 100000)
	{

		if($kilometer_akhir >= 10000 AND $kilometer_akhir < 12500 AND $km_serv !='10000')
		{
			$description = $servis1."<br>";
			$description .=$service2."<br>";
			$km_service   = 10000;
		}
		elseif($kilometer_akhir >= 12500 AND $kilometer_akhir < 15000 AND $km_serv !='12500')
		{
			$description = $servis1."<br>";
			$km_service   = 12500;
		}
		elseif($kilometer_akhir >= 15000 AND $kilometer_akhir < 17500 AND $km_serv !='15000')
		{
			$description = $servis1."<br>";
			$km_service   = 15000;
		}
		elseif($kilometer_akhir >= 17500 AND $kilometer_akhir < 20000 AND $km_serv !='17500')
		{
			$description = $servis1."<br>";
			$km_service   = 17500;
		}
		elseif($kilometer_akhir >= 20000 AND $kilometer_akhir < 22500 AND $km_serv !='20000')
		{
			$description = $servis1."<br>";
			$description .= $servis2."<br>";
			$km_service   = 20000;
		}
		elseif($kilometer_akhir >= 22500 AND $kilometer_akhir < 25000 AND $km_serv !='22500')
		{
			$description = $servis1."<br>";
			$km_service   = 22500;
		}
		elseif($kilometer_akhir >= 25000 AND $kilometer_akhir < 27500 AND $km_serv !='25000')
		{
			$description = $servis1."<br>";
			$km_service   = 25000;
		}
		elseif($kilometer_akhir >= 27500 AND $kilometer_akhir < 30000 AND $km_serv !='27500')
		{
			$description = $servis1."<br>";
			$km_service   = 27500;
		}
		elseif($kilometer_akhir >= 30000 AND $kilometer_akhir < 32500 AND $km_serv !='30000')
		{
			$description = $servis1."<br>";
			$description .= $servis2."<br>";
			$km_service   = 30000;
		}
		elseif($kilometer_akhir >= 32500 AND $kilometer_akhir < 35000 AND $km_serv !='32500')
		{
			$description = $servis1."<br>";
			$km_service   = 32500;
		}
		elseif($kilometer_akhir >= 35000 AND $kilometer_akhir < 37500 AND $km_serv !='35000')
		{
			$description = $servis1."<br>";
			$km_service   = 35000;
		}
		elseif($kilometer_akhir >= 37500 AND $kilometer_akhir < 40000 AND $km_serv !='30000')
		{
			$description = $servis1."<br>";
			$km_service   = 37500;
		}
		elseif($kilometer_akhir >= 40000 AND $kilometer_akhir < 42500 AND $km_serv !='30000')
		{
			$description = $servis1."<br>";
			$description .= $servis2."<br>";
			$km_service   = 40000;
		}
		elseif($kilometer_akhir >= 42500 AND $kilometer_akhir < 45000 AND $km_serv !='42500')
		{
			$description = $servis1."<br>";
			$km_service   = 42500;
		}
		elseif($kilometer_akhir >= 45000 AND $kilometer_akhir < 47500 AND $km_serv !='45000')
		{
			$description = $servis1."<br>";
			$km_service   = 45000;
		}
		elseif($kilometer_akhir >= 47500 AND $kilometer_akhir < 50000 AND $km_serv !='47500')
		{
			$description = $servis1."<br>";
			$km_service   = 47500;
		}elseif($kilometer_akhir >= 50000 AND $kilometer_akhir < 52500 AND $km_serv !='50000')
		{
			$description = $servis1."<br>";
			$description .= $servis2."<br>";
			$km_service   = 50000;
		}elseif($kilometer_akhir >= 52500 AND $kilometer_akhir < 55000 AND $km_serv !='52500')
		{
			$description = $servis1."<br>";
			$km_service   = 52500;
		}
		elseif($kilometer_akhir >= 55000 AND $kilometer_akhir < 57500 AND $km_serv !='55000')
		{
			$description = $servis1."<br>";
			$km_service   = 55000;
		}elseif($kilometer_akhir >= 57500 AND $kilometer_akhir < 60000 AND $km_serv !='57500')
		{
			$description = $servis1."<br>";
			$km_service   = 57500;
		}elseif($kilometer_akhir >= 60000 AND $kilometer_akhir < 62500 AND $km_serv !='60000')
		{
			$description = $servis1."<br>";
			$description .= $servis2."<br>";
			$km_service   = 60000;
		}elseif($kilometer_akhir >= 62500 AND $kilometer_akhir < 65000 AND $km_serv !='62500')
		{
			$description = $servis1."<br>";
			$km_service   = 62500;
		}elseif($kilometer_akhir >= 65000 AND $kilometer_akhir < 67500 AND $km_serv !='65000')
		{
			$description = $servis1."<br>";
			$km_service   = 65000;
		}elseif($kilometer_akhir >= 67500 AND $kilometer_akhir < 70000 AND $km_serv !='67500')
		{
			$description = $servis1."<br>";
			$km_service   = 67500;
		}elseif($kilometer_akhir >= 70000 AND $kilometer_akhir < 72500 AND $km_serv !='70000')
		{
			$description = $servis1."<br>";
			$description .= $servis2."<br>";
			$km_service   = 70000;
		}
		elseif($kilometer_akhir >= 72500 AND $kilometer_akhir < 75000 AND $km_serv !='72500')
		{
			$description = $servis1."<br>";
			$km_service   = 72500;
		}
		elseif($kilometer_akhir >= 75000 AND $kilometer_akhir < 77500 AND $km_serv !='75000')
		{
			$description = $servis1."<br>";
			$km_service   = 75000;
		}elseif($kilometer_akhir >= 77500 AND $kilometer_akhir < 80000 AND $km_serv !='77500')
		{
			$description = $servis1."<br>";
			$km_service   = 77500;
		}elseif($kilometer_akhir >= 80000 AND $kilometer_akhir < 82500 AND $km_serv !='80000')
		{
			$description = $servis1."<br>";
			$description .= $servis2."<br>";
			$km_service   = 80000;
		}elseif($kilometer_akhir >= 82500 AND $kilometer_akhir < 85000 AND $km_serv !='82500')
		{
			$description = $servis1."<br>";
			$km_service   = 82500;
		}
		elseif($kilometer_akhir >= 85000 AND $kilometer_akhir < 87500 AND $km_serv !='85000')
		{
			$description = $servis1."<br>";
			$km_service   = 85000;
		}
		elseif($kilometer_akhir >= 87500 AND $kilometer_akhir < 90000 AND $km_serv !='87500')
		{
			$description = $servis1."<br>";
			$km_service   = 87500;
		}
		elseif($kilometer_akhir >= 90000 AND $kilometer_akhir < 92500 AND $km_serv !='90000')
		{
			$description = $servis1."<br>";
			$description .= $servis2."<br>";
			$km_service   = 90000;
		}
		elseif($kilometer_akhir >= 92500 AND $kilometer_akhir < 95000 AND $km_serv !='92500')
		{
			$description = $servis1."<br>";
			$km_service   = 92500;
		}
		elseif($kilometer_akhir >= 95000 AND $kilometer_akhir < 97500 AND $km_serv !='95000')
		{
			$description = $servis1."<br>";
			$km_service   = 95000;
		}
		elseif($kilometer_akhir >= 95000 AND $kilometer_akhir < 97500 AND $km_serv !='95000')
		{
			$description = $servis1."<br>";
			$km_service   = 95000;
		}
		elseif($kilometer_akhir >= 97500 AND $kilometer_akhir < 100000 AND $km_serv !='97500')
		{
			$description = $servis1."<br>";
			$km_service   = 97500;
		}
	}
