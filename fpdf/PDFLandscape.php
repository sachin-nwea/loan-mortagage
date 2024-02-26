<?php
require('fpdf.php');

class PDFLandscape extends FPDF
{
    // Simple table
    function getMortgageData($header, $data, $mortgages, $widths, $heights, $heightMortgage, $customer, $bank)
    {
        $this->SetFont('times', '', 10);
        $this->Row($header);
        $i = 1;
        $y = 74;
        $finalRateX= 227;
        $finalValueX= 255;

        foreach ($data as $mortgage) {
            $this->Cell($widths[0], $heights, $i++, 1);
            $this->Cell($widths[1], $heights, $mortgage['ornament_name'], 1);
            $this->Cell($widths[2], $heights, $mortgage['no_of_units'], 1);
            $this->Cell($widths[3], $heights, $mortgage['weight'], 1);
            $this->Cell($widths[4], $heights, $mortgage['net_weight'], 1);
            $this->Cell($widths[5], $heights, $mortgage['carat_purity'], 1);
            $this->Cell($widths[6], $heights, $mortgage['equivalent_weight'], 1);
            $this->rupeeImage($finalRateX,$y,3);
            $this->Cell($widths[7],$heights,'    '  .$mortgage['rate_per_gram'],1);
            $this->rupeeImage($finalValueX,$y,3);
            $this->Cell($widths[8],$heights,'    ' .    $mortgage['final_value'],1);
            $y +=5;
            $this->Ln();
        }
        $finalTotalX = 211;
        $this->SetFont('times', 'B', 10);
        $this->Cell((int)$widths[0] + (int)$widths[1], $heightMortgage, 'Total   ', 1, 0, 'R');
        $this->SetFont('times', '', 10);
        $this->Cell($widths[2], $heightMortgage, $mortgages['total_no_of_units'], 1);
        $this->Cell($widths[3], $heightMortgage, $mortgages['total_weight'], 1);
        $this->Cell($widths[4], $heightMortgage, $mortgages['total_net_weight'], 1);
        $this->Cell($widths[5], $heightMortgage, '', 1);
        $this->Cell($widths[6], $heightMortgage, $mortgages['total_equivalent_weight'], 1);
        $this->Cell($widths[7], $heightMortgage, '', 1);
        $this->SetFont('times', 'B', 10);
        $this->rupeeImage($finalValueX,$y,3);
        $this->Cell($widths[8], $heightMortgage, '    '.$mortgages['total_amount'], 1);
        $this->SetFont('times', 'B', 10);

        //this is for below total columns.
        $totalWidths = (int)$widths[0] + (int)$widths[1] + (int)$widths[2] + (int)$widths[3] + (int)$widths[4] + (int)$widths[5] + (int)$widths[6];
        $restWidths = (int)$widths[7] + (int)$widths[8];
        $finalWidths = (int) $totalWidths + (int) $restWidths;
        $remainingWidth = $totalWidths - (int)$widths[6];
        $initialWidth = $widths[0] + (int)$widths[1] + (int)$widths[2] + (int)$widths[3] ;
        $this->Ln();
        $this->Cell($remainingWidth, $heightMortgage, 'Value of Gold as per Market Rate', 1);
        $y +=5;
        $this->rupeeImage($finalTotalX,$y,3);
        $this->Cell($widths[6], $heightMortgage, ceil($mortgages['total_amount']), 1, 0, 'R');

        $this->SetFont('times', '', 10);
        $this->Cell($restWidths, $heightMortgage, '', 1);
        $this->Ln();
        $this->Cell($initialWidth, $heightMortgage, 'Value of Gold as Per Bank CardRate (Total wt.in 22ct)', 1);
        $this->Cell($widths[4], $heightMortgage, '0.00', 0);
        $this->Cell($widths[5], $heightMortgage, 'Grams', 0, 0, 'R');
        $this->SetFont('times', 'B', 10);
        $this->Cell($widths[6], $heightMortgage, $mortgages['total_equivalent_weight'], 1, 0, 'R');
        $this->SetFont('times', '', 10);
        $this->Cell($restWidths, $heightMortgage, '', 1);
        $this->Ln();
        $this->Cell($remainingWidth, $heightMortgage, 'Minimum of Above two', 1);
        $this->SetFont('times', 'B', 10);
        $y +=10;
        $this->rupeeImage($finalTotalX,$y,3);
        $this->Cell($widths[6], $heightMortgage, ceil($mortgages['total_amount']), 1, 0, 'R');
        $this->SetFont('times', '', 10);
        $this->Cell($restWidths, $heightMortgage, '' , 1);
        $this->Ln();
        $this->Cell($remainingWidth, $heightMortgage, 'Less Margin (25%)', 1);
        $this->SetFont('times', 'B', 10);
        $eligible = ceil($mortgages['total_amount'] * 0.75);
        $y +=5;
        $this->rupeeImage($finalTotalX,$y,3);
        $this->Cell($widths[6], $heightMortgage, $eligible, 1, 0, 'R');
        $this->SetFont('times', '', 10);
        $this->Cell($restWidths, $heightMortgage, '', 1);
        $this->Ln();
        $this->Cell($remainingWidth, $heightMortgage, 'Eligible Amount', 1);
        $this->SetFont('times', 'B', 10);
        $y +=5;
        $this->rupeeImage($finalTotalX,$y,3);
        $this->Cell($widths[6], $heightMortgage, $eligible, 1, 0, 'R');
        $this->SetFont('times', '', 10);
        $this->Cell($restWidths, $heightMortgage, '', 1);

        $this->Ln();
        $this->Cell($remainingWidth, $heightMortgage, 'Loan Requested by Borrower', 1);
        $this->Cell($widths[6], $heightMortgage, '', 1, 0, 'R');
        $this->Cell($restWidths, $heightMortgage, '', 1);
        $this->Ln();
        $this->Cell($remainingWidth, $heightMortgage, 'Loan to be sanctioned (minimum of eligible amount Or Loan Requirement)', 1);
        $this->Cell($widths[6], $heightMortgage, '', 1, 0, 'R');
        $this->Cell($restWidths, $heightMortgage, '', 1);
        $this->Ln();

        $bankName = strtolower($bank);
        $y += 4 * $heightMortgage;
        $height = 0;
        if(str_contains(  $bankName, 'state') || str_contains( 'sbi', $bankName)) {
            $this->printDeclarationForm($y, $customer, 6);
            $countRows = count($data);
            $height = ($countRows > 7)? 32: 36;
        } else if (str_contains($bankName, 'idbi')) {
            $this->printDeclarationFormIDBI($y, $mortgages['total_equivalent_weight'], $eligible,6);
            $countRows = count($data);
            $height = ($countRows > 7) ? 30: 28;
        }

        $this->Cell($finalWidths, $height, '', 1);
    }
    public function rupeeImage($x, $y, $width) {
        $this->Image('assets/images/rupee.png', $x, $y, $width);
    }

    /**
     * To Print the format for IDBI bank.
     * @param $pos
     * @param $total_equivalent_weight
     * @param $eligible
     * @param $x
     * @return void
     */
    public function printDeclarationFormIDBI($pos, $total_equivalent_weight, $eligible, $x) {
        $this->Text($x, $pos, 'I Mr. '. $_SESSION['full_name'] .' son of Mr. '. $_SESSION['father_name']. ' aged about '.$_SESSION['age'].' Years residing at '.$_SESSION['area'].' hereby certify that I have checked and weighted the above mentioned gold ornaments/coins/issued by');
        $pos +=5;
        $this->Text($x, $pos, ' bank/jewellery and the Net Weight of gold therein is '.$total_equivalent_weight.' Grams of 22 carat purity. I hereby certify that the Bank may safety grant a loan of '. $eligible.'/- against pledge of the said the gold ornaments');
        $pos += 5;
        $this->Text($x, $pos, '/coins issued by bank /jewellery. I am ready to purchase these gold ornaments/coin issued by banks/jewellery at market rate at any time as and when demanded by the Bank. ');
        $pos += 10;
        $this->SetFont('times', 'B', 10);
        $this->Text($x, $pos, ' Date: '. date('d-m-Y h:i A'));
    }

    /**
     * to Print the text for SBI bank
     * @param $pos
     * @param $customer
     * @param $x
     * @return void
     */
    public function printDeclarationForm($pos, $customer, $x) {
        $pos -= 2;
        $this->SetFont('times', 'B', 10);
        $this->Text($x, $pos, 'Dear sir,');
        $this->SetFont('times', '', 10);
        $pos +=5;
        $this->Text($x, $pos, 'We hereby certify that Mr./Mrs.' . $customer['f_name'] . ' ' . $customer['l_name'] . ' S/W/D of	                                               Resident of	'.$customer['address']);
        $pos += 5;
        $this->Text($x, $pos, ' who has sought gold loan from the Bank is not my relative and the gold against which the loan is not purchased from me. The Ornaments coins have been weighted and appraised by me on ');
        $pos += 5;
        $this->Text($x, $pos, date('d-m-Y'). ' in the presence of Shri/Smt                                                                              (cash in charge/Officer)  and the exact weight, Purity of the metal and market value  of each item as on date ');
        $pos += 5;
        $this->Text($x, $pos, ' are indicated above:');
        $pos += 10;
        $this->SetFont('times', 'B', 10);
        $this->Text($x, $pos, ' Date: '. date('d-m-Y h:i A'));

    }

    /**
     * @param $images
     * @return void
     */
    function headerImage($images)
    {
        // Add Bank logo to page
        $this->Image($images[0], 5, 5, 43, 28);
        // Add logo to page
        $this->Image($images[1], 145, 5, 36);

        //water mark image
        $this->Image($images[2], 130, 115, 50);
        //Small Logo image
        $this->Image($images[3], 224, 5, 10);
        $this->Ln(53);
    }

    function storeDetails($storeDetails, $banks_options, $bankName, $customers_mortgage){

        $this->SetFont('times', '', 10);
        $pos = 10;
        $start = 247;
        // Line break
        $this->SetFont('times','B',18);
        $this->Text($start, $pos, $storeDetails['store_name']);

        $this->SetFont('times', 'U', 10);
        $pos += 7;
        $this->Text($start + 14, $pos, $storeDetails['store_detail']);
        $this->SetFont('times', '', 10);

        $pos += 6;
        $this->Text($start- 54, $pos, $storeDetails['address']);

        $phoneMobileText = '';
        $finalTextpos= 0;
        if($storeDetails['phone']) {
            $pos += 6;
            $phoneMobileText = 'Phone '.$storeDetails['phone'];
            $finalTextpos = 12;
        }
        if($storeDetails['mobile']) {
            $phoneMobileText .= ' Mobile ' . $storeDetails['mobile'];
            $finalTextpos += 12;
        }
        if($storeDetails['mobile2']) {
            $phoneMobileText .= '/' . $storeDetails['mobile'];
            $finalTextpos +=11;
        }
        $this->Text($start -$finalTextpos, $pos,  $phoneMobileText);

         if($storeDetails['email']) {
             $pos += 5;
             $this->Text($start, $pos, 'Email ' . $storeDetails['email']);
         }

        //Printing bank details
        if($banks_options['account_number']) {
            $pos += 5;

            $bankLength = strlen($bankName);
            $extraSpace = ($bankLength > 11)? $bankLength - 5 : $bankLength - 11;
            $newStart = $start - 10 - $extraSpace;
            $this->Text($newStart, $pos, $bankName. ' A/C No:'. $banks_options['account_number']);
        }
        $this->SetFont('times', 'B', 11);
        $pos += 14;
        $this->Text($start - 127 , $pos, 'Certificate of Goldsmith ');
        $pos += 4;
        $this->Text($start - 141, $pos, 'Details of Gold Ornaments / Jewellery');
        $this->SetFont('times', '', 10);
        $text = '';
        if ($customers_mortgage['acid_test'])
            $text .='Acid Test, ';
        if($customers_mortgage['sound_test'])
            $text .='Sound Test, ';
        if($customers_mortgage['touch_sound_test'])
            $text .='Touch Sound Test';
        $this->Text($start - 70, $pos, 'Method(s) Used for Purity Testing:');
        $this->SetFont('times', 'B', 10);
        $this->Text($start - 20, $pos, $text);
        $this->SetFont('times', '', 10);

    }

    /**
     * Print Customer details in Landscape mode
     * @param $customer
     * @return void
     *
     */
    public function printCustomerDetails($customer, $bank, $mortgages) {
        $this->SetFont('times', '', 12);
        $pos = 10;
        $this->Text(50,$pos,  $bank);
        $pos += 6;
        $this->Text(50,$pos, $mortgages['branch_name']);
        //print the Duration.
        $pos += 6;
        $this->Text(50,$pos, 'Duration: '. $mortgages['interest_payment_type']);
        $pos += 6;
        $this->Text(50, $pos, 'Name: '.('Mr./Mrs./Miss. : '). ucfirst($customer['f_name']).' '. ucfirst($customer['l_name']));

        if ($customer['address']) {
            $pos += 6;
            $this->Text(50, $pos, 'Address: '. $customer['address']);
        }
        if($customer['phone']) {
            $pos += 6;
            $this->Text(50, $pos, 'Mobile No.: '. $customer['phone'] . ($customer['phone2'] ? '/ '. $customer['phone2'] : ''));
        }
        $pos += 6;
        $this->Text(50, $pos, 'Bag No. IBLM/IBLS');
        $this->SetFont('times', '', 10);
    }

    /**
     * @param $banks
     * @param $customer
     * @param $storeDetails
     * @param $banks_options
     * @param $mortgages
     * @param $customers_mortgages
     * @param $countofPages
     * @return void
     */
    public function printLandscapeData($banks, $customer, $storeDetails, $banks_options, $mortgages, $customers_mortgages) {
        // Add a new page
        $this->SetMargins(5, 5);
        $this->SetAutoPageBreak('false');
        $this->AddPage('L', 'a4');
        $this->Rect(2, 2, 292, 205);
        $banksName = $banks['bank_name'];
        $this->headerImage(array($banks['logo'], 'assets/images/logo.jpg', 'assets/images/watermarkG20.png', 'assets/images/small_logo.jpg'));
        $this->printCustomerDetails($customer,$banksName, $customers_mortgages);
        $this->storeDetails($storeDetails, $banks_options, $banksName, $customers_mortgages);
        // Column titles given by the programmer
        $header = array('Sr. No', 'Description of Gold Ornaments', 'No Of Units', 'Gross Weight in Grams',
            'Net Weight (Gross Weight less Vaux, Stones, dust etc) Grams', 'Purity in Carat', 'Equivalent weight of 22 carat in (Grams)', 'Gold Rate Per Gram', 'Approx Value In Rupees');

        $widths = array(10, 52, 20, 30, 45, 24, 40, 28, 38);
        $height = 5;
        $heightMortgage = 5;
        $this->SetWidths($widths);
        $this->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
        $this->getMortgageData($header, $mortgages, $customers_mortgages, $widths, $height, $heightMortgage, $customer, $banks['bank_name']);
    }

    public function outPrint() {
        $this->Output();
    }
    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data)
    {
        // Calculate the height of the row
        $nb = 0;
        $countRows = count($data);
        for($i=0;$i<$countRows;$i++)
            $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h = 5*$nb;
        // Issue a page break first if needed
        //$this->CheckPageBreak($h);
        // Draw the cells of the row
        for($i=0;$i<$countRows;$i++)
        {
            $w = $this->widths[$i];
            $a = $this->aligns[$i] ?? 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x,$y,$w,$h);
            // Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            // Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        // Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if(!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',(string)$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

}

?>
