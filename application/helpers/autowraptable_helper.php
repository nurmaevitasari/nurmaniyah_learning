<?php  
     
    /**
     * @author Achmad Solichin
     * @website http://achmatim.net
     * @email achmatim@gmail.com
     */
    //require_once("fpdf/fpdf.php");
    require("fpdf/fpdf.php");
     
    class AutoWrapTable extends FPDF {
      	private $data = array();
      	private $options = array(
      		'filename' => '',
      		'destinationfile' => '',
      		'paper_size'=>'A4',
      		'orientation'=>'P'
      	);
     
      	function __construct($data = array(), $options = array()) {
        	parent::__construct();
        	$this->data = $data;
        	$this->options = $options;
    	}
     
    	public function rptDetailData () {
    		//
    		$border = 0;
    		$this->AddPage();
    		$this->SetAutoPageBreak(true,60);
    		$this->AliasNbPages();
    		$left = 25;
			
			$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			$uri_segments = explode('/', $uri_path);

			$bln = $uri_segments[4];
			$bln = strtotime($bln);
			
			$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
			$bulan = $bulan[date('n', $bln)].", ".date('Y', $bln);
			
			
    		//header		
			$this->Image(base_url('assets/images/aa.gif'),468,23,100);
    		$this->SetFont("", "B", 15);
    		$this->MultiCell(0, 20, 'PT. INDOTARA PERSADA');
    		$this->Cell(0, 1, " ", "B");
    		$this->Ln(40);
    		$this->SetFont("Times", "B", 16);
    		$this->SetX($left); $this->Cell(0, 0, 'POINT SUMMARY',0,1,'C');
			$this->Ln(15);
			$this->SetFont("Times", "", 10);
    		$this->SetX($left); $this->Cell(0, 0, $bulan, 0, 2,'C');
    		$this->Ln(35);
			
     
    		$h = 20;
    		$left = 40;
    		$top = 80;	
    		#tableheader
			$this->SetFont("Arial", "B", 9);
    		$this->SetFillColor(151, 184, 237);	
    		$left = $this->GetX();
    		$this->Cell(20,$h,'No.',1,0,'L',true);
    		$this->SetX($left += 20); $this->Cell(85, $h, 'Teknisi', 1, 0, 'C',true);
    		$this->SetX($left += 85); $this->Cell(60, $h, 'Total Point', 1, 0, 'C',true);
    		$this->SetX($left += 60); $this->Cell(60, $h, 'Tariff', 1, 0, 'C',true);
			$this->SetX($left += 60); $this->Cell(65, $h, 'Total Bonus', 1, 0, 'C',true);
    		$this->SetX($left += 65); $this->Cell(100, $h, 'Status', 1, 0, 'C',true);
    		$this->SetX($left += 100); $this->Cell(149, $h, 'Notes', 1, 1, 'C',true);
    		//$this->Ln(20);
     
    		$w=array(20,85,60,60,65,100,149);
            $this->SetFont('Arial','',8);
    		$this->SetWidths($w);
    		$this->SetAligns(array('C','L','C','R','R','C','L'));
    		$no = 1; $this->SetFillColor(255);
			//$status = "Unpaid";
    		foreach ($this->data['res'] as $baris) {
				$tariff = $baris["tariff"];
				
				if ($tariff == '') {
					$tariff = '0';
				}else {
					$tariff = $tariff;
				}

                $final_point = $baris['total_point'] + $baris['point_tambahan'];

				$trf = str_replace(".", "", $tariff);
				$tariff = "Rp. ".number_format($trf, "0", ",", ".");
				
				$bonus = $final_point * $trf;
				$bonus = "Rp. ".number_format($bonus, "0", ",", ".");
				
				$paid_date = date('d-m-Y H:i:s', strtotime($baris['paid_date']));
				if($baris['paid_status'] == 1)
				{
					$status = "Paid by ".$baris["user_paid"]."\n [".$paid_date."]";
				}else{
					$status = "Unpaid";
				}
				
				//add fix value to table
    			$this->Row(
    				array($no++, 
    				$baris['nickname'], 
    				$final_point, 
    				$tariff,
					$bonus,						
    				$status,				
    				$baris['notes']
    			));
    		}
            $this->Cell(array_sum($w),0,'','T');

            $this->Ln(20);
            $this->SetFont("Times", "B", 12);
            $this->SetX(25); $this->Cell(0, 0, 'Total All Point : '.$this->data['all_point']['total_point'].'',0,1,'L');
            
            $this->Ln(15);
            $this->SetFont("Times", "B", 12);
            $this->SetX(25); $this->Cell(0, 0, 'Total All Bonus : Rp. '.number_format($this->data['all_point']['total_tariff'], "0", ",", ".").'',0,1,'L');



     
    	}
     
    	public function printPDF () {
     
    		if ($this->options['paper_size'] == "F4") {
    			$a = 8.3 * 72; //1 inch = 72 pt
    			$b = 13.0 * 72;
    			$this->FPDF($this->options['orientation'], "pt", array($a,$b));
    		} else {
    			$this->FPDF($this->options['orientation'], "pt", $this->options['paper_size']);
    		}
     
    	    $this->SetAutoPageBreak(false);
    	    $this->AliasNbPages();
    	    $this->SetFont("helvetica", "B", 10);
    	    //$this->AddPage();
     
    	    $this->rptDetailData();
     
    	    $this->Output($this->options['filename'],$this->options['destinationfile']);
      	}
     
      	private $widths;
    	private $aligns;
     
    	function SetWidths($w)
    	{
    		//Set the array of column widths
    		$this->widths=$w;
    	}
     
    	function SetAligns($a)
    	{
    		//Set the array of column alignments
    		$this->aligns=$a;
    	}
		
    	function Row($data)
    	{
    		//Calculate the height of the row
    		$nb=0;
    		for($i=0;$i<count($data);$i++)
    			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    		$h=12*$nb;
    		//Issue a page break first if needed
    		$this->CheckPageBreak($h);
    		//Draw the cells of the row
    		for($i=0;$i<count($data);$i++)
    		{
    			$w=$this->widths[$i];
    			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
    			//Save the current position
    			$x=$this->GetX();
    			$y=$this->GetY();

    			//Draw the border
    			$this->Rect($x,$y,$w,$h);
    			//Print the text
               
    			$this->MultiCell($w,10,$data[$i],0,$a);
    			//Put the position to the right of the cell
    			$this->SetXY($x+$w,$y);
               
    		}

    		//Go to the next line
    		$this->Ln($h);
    	}
     
    	function CheckPageBreak($h)
    	{
    		//If the height h would cause an overflow, add a new page immediately
    		if($this->GetY()+$h>$this->PageBreakTrigger)
    			$this->AddPage($this->CurOrientation);
    	}
     
    	function NbLines($w,$txt)
    	{
    		//Computes the number of lines a MultiCell of width w will take
    		$cw=&$this->CurrentFont['cw'];
    		if($w==0)
    			$w=$this->w-$this->rMargin-$this->x;
    		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    		$s=str_replace("\r",'',$txt);
    		$nb=strlen($s);
    		if($nb>0 and $s[$nb-1]=="\n")
    			$nb--;
    		$sep=-1;
    		$i=0;
    		$j=0;
    		$l=0;
    		$nl=1;
    		while($i<$nb)
    		{
    			$c=$s[$i];
    			if($c=="\n")
    			{
    				$i++;
    				$sep=-1;
    				$j=$i;
    				$l=0;
    				$nl++;
    				continue;
    			}
    			if($c==' ')
    				$sep=$i;
    			$l+=$cw[$c];
    			if($l>$wmax)
    			{
    				if($sep==-1)
    				{
    					if($i==$j)
    						$i++;
    				}
    				else
    					$i=$sep+1;
    				$sep=-1;
    				$j=$i;
    				$l=0;
    				$nl++;
    			}
    			else
    				$i++;
    		}
    		return $nl;
    	}
    } //end of class
     
    
    ?>