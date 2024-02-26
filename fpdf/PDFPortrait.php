<?php
class PDFPortrait extends FPDF
{
    // Simple table
    function getMortgageData($header, $data, $mortgages, $widths, $height, $heightMortgage, $y)
    {
        $this->SetFont('times', '', 10);
        $this->Row($header);
        $i = 1;
        foreach ($data as $mortgage) {
            $this->Cell($widths[0], $height, $i++, 1);
            $this->Cell($widths[1], $height, $mortgage['ornament_name'], 1);
            $this->Cell($widths[2], $height, $mortgage['no_of_units'], 1);
            $this->Cell($widths[3], $height, $mortgage['weight'], 1);
            $this->Cell($widths[4], $height, $mortgage['net_weight'], 1);
            $this->Cell($widths[5], $height, $mortgage['carat_purity'], 1);
            $this->Cell($widths[6], $height, $mortgage['equivalent_weight'], 1);
            $this->rupeeImage(157,$y,3);
            $this->Cell($widths[7],$height,'     '. $mortgage['rate_per_gram'],1);
            $this->rupeeImage(174,$y,3);
            $this->Cell($widths[8],$height,'     '. number_format($mortgage['final_value'], 2),1);
            $y +=6;
            $this->Ln();
        }
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

        $this->rupeeImage(174,$y,3);
        $this->Cell($widths[8], $heightMortgage, '     '. number_format($mortgages['total_amount'], 2), 1);
        $this->SetFont('times', 'B', 10);
        $this->Ln();
        //this is for below total columns.
        $this->Cell(array_sum($widths), 80, '', 1);
        $this->SetFont('times', '', 10);
        $y += 10;
        $this->Text(12, $y, 'Date:  '. date('d-m-Y h:i A'));
        $y += 6;
        $this->Text(12, $y, 'Place:  ');

        $z = $y;
        $z +=4;

        $this->Rect(60, $y, 30, 6, 'D');
        $this->Text(68, $z, 'valuation');

        $this->Rect(90, $y, 30, 6, 'D');
        $this->Text(98, $z, '75%');
        $this->Rect(120, $y, 30, 6, 'D');
        $this->Text(128, $z, '80%');

        $z =$y + 6;
        $new = $z+5;
        $rupee = $z + 2.5;
        $this->Rect(60, $z, 30, 6, 'D');
        $this->rupeeImage(64,$rupee,3);
        $this->Text(68, $new, number_format($mortgages['total_amount'], 2));

        $this->Rect(90, $z, 30, 6, 'D');
        $this->rupeeImage(94,$rupee,3);
        $this->Text(98, $new, number_format($mortgages['total_amount'] * 0.75, 2));
        $this->Rect(120, $z, 30, 6, 'D');
        $this->rupeeImage(124,$rupee,3);
        $this->Text(128, $new, number_format($mortgages['total_amount'] * 0.80, 2));
        $y += 6;
        $this->Text(12, $y, 'Pouch No:  ');
        $y += 40;
        $this->SetFont('times', 'B', 10);
        $this->Text(12, $y, 'Signature Of  Borrower  ');
        $y += 6;
        $this->SetFont('times', '', 10);
        $this->Text(12, $y, 'Name/Address  ');
        $this->SetFont('times', 'B', 10);
        $y += 14;
        $this->Text(92, $y, 'Authorised Signatories  ');

        $this->Text(168, $y, 'For Anand Jewellers  ');
    }

    function storeDetails($storeDetails, $banks_options, $bankName, $branchName, $pos = 10){

        $this->SetFont('times', '', 10);
        $pos = 10;
        $start = 160;

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
        if($storeDetails['phone']) {
            $pos += 6;
            $phoneMobileText = 'Phone '.$storeDetails['phone'];
        }
        if($storeDetails['mobile']) {
            $phoneMobileText .= ' Mobile ' . $storeDetails['mobile'];
        }
        if($storeDetails['mobile2']) {
            $phoneMobileText .= '/' . $storeDetails['mobile'];
        }
        $this->Text($start -35 , $pos,  $phoneMobileText);

        $pos += 5;
        $this->Text($start, $pos, 'Email ' . $storeDetails['email']);

        //Printing bank details
        if($banks_options['account_number']) {
            $pos += 5;

            $bankLength = strlen($bankName);
            $extraSpace = ($bankLength > 11)? $bankLength - 5 : $bankLength - 11;
            $newStart = $start - 10 - $extraSpace;
            $this->Text($newStart, $pos, $bankName. ' A/C No:'. $banks_options['account_number']);
        }
        $bank = $this->checkBankName($bankName);
        switch ($bank) {
            case 'Canara':
                $this->printDeclarationFormCanara($pos, $bankName, $branchName, $banks_options['gold_rate'], 12, 32, 193, $storeDetails['store_name']);
                break;
            default:
                $this->printDeclarationForm($pos, $bankName, $branchName, $banks_options['gold_rate'], 12, 62, 193);
                break;
        }
    }
    public function printDeclarationFormCanara($pos, $bank_name, $branchName, $goldRate, $x, $height, $width, $storeName) {
        $this->Cell($width, $height, '', 1);
        $this->Ln();
        $this->SetFont('times', 'U', 10);
        $pos += 20;
        $this->Text($x, $pos, 'Declaration of the Borrower:	');
        $this->SetFont('times', 'B', 10);
        $this->Text(160, $pos, 'Date:  '. date('d-m-Y h:i A'));
        $this->SetFont('times', '', 10);
        $pos += 5;
        $this->Text($x, $pos, 'I declare that I have handed over the above ornaments to the bank without any pressure and in good state of mind for the purpose of');
        $pos += 5;
        $this->Text($x, $pos, 'Gold Loan from ');
        $this->SetFont('times', 'B', 10);
        $this->Text($x+24, $pos, $bank_name. ' '.$branchName);
        $length= 1.7 * strlen($bank_name. ' '.$branchName);
        $this->SetFont('times', '', 10);
        $this->Text($x+24 + $length, $pos, ' All the above ornaments are belonging  to me and I have full');
        $pos += 5;
        $this->Text($x, $pos, 'ownership of the above ornaments. I also fully agree for the above certificate given by '. $storeName);
        $pos += 10;
        $this->SetFont('times', 'B', 10);
        $this->Text($height+40, $pos, 'Description of the Gold Ornaments/Articles');
        $this->Text(172, $pos, 'Market Rate:  '.$goldRate);
        $this->SetFont('times', '', 10);
    }

    public function printDeclarationFormOtherBank($pos, $bank_name, $branchName, $goldRate, $x, $height, $width) {
        $this->Cell($width, $height, '', 1);
        $this->Ln();
    }

    public function checkBankName($bankName) {
        if(str_contains($bankName, 'india') || str_contains($bankName, 'bank of')) {
            $bankName = 'BOI';
        } else if (str_contains(strtolower($bankName), 'canara')) {
            $bankName = 'Canara';
        }
        return $bankName;
    }

    /**
     * using for Portrait mode
     * @param $pos
     * @param $start
     * @return void
     */
    public function printDeclarationForm($pos, $bank_name, $branchName, $goldRate, $x, $height, $width) {

        $this->Cell($width, $height, '', 1);
        $this->Ln();
        $this->SetFont('times', '', 10);
        $pos += 20;
        $this->Text($x, $pos, 'To');
        $this->SetFont('times', 'B', 10);
        $this->Text(160, $pos, 'Date:  '. date('d-m-Y h:i A'));
        $this->SetFont('times', '', 10);
        $pos += 5;
        $this->Text($x, $pos, 'The Manager,');
        $pos += 5;
        $this->SetFont('times', 'B', 10);
        $this->Text($x, $pos, $bank_name);
        $pos += 5;
        $this->SetFont('times', '', 10);
        $this->Text($x, $pos, $branchName);

        $pos += 5;
        $this->SetFont('times', 'B', 10);
        $this->Text(62, $pos, 'CERTIFICATE OF APPROVED GOLD SMITH/VALUER');
        $pos += 5;
        $this->SetFont('times', '', 10);

        $this->Text($x, $pos, 'I have carefully tested/examined the purity, weight and value of the Gold Ornaments/Articles, details given below and hereby certify');
        $pos += 5;
        $this->Text($x, $pos, 'that the Purity,weight  and value of the Gold Ornaments/Articles are correct to the best of my Knowledge and belief and I guarantee');
        $pos += 5;
        $this->Text($x, $pos, 'and hold myself responsible for the same. In the event of any inconsistency/mistake in my certification, asa above and due to which, ');
        $pos += 5;
        $this->Text($x, $pos, 'the bank suffers any loss or damage, the same will be reimbursed by me to the Bank without any condition/s. I further declare and');
        $pos += 5;
        $this->Text($x, $pos, 'confirm that the above Loan Applicant/s is/are not related to me or acquaintance of mine.');
        $this->SetFont('times', 'B', 10);
        $pos += 10;
        $this->Text($height, $pos, 'Description of the Gold Ornaments/Articles');
        $this->Text(172, $pos, 'Market Rate:  '.$goldRate);
        $this->SetFont('times', '', 10);

    }

    /**
     * @param $images
     * @return void
     */
    function HeaderPortraitImage($images)
    {
        // Add logo to page
        $this->Image($images[0], 45, 5, 33);
        // Add Bank logo to page
        $this->Image($images[1], 5, 5, 36, 33);

        //water mark image
        $this->Image($images[2], 130, 135, 50);

        $this->Image('assets/images/watermark_logo.jpg', 60, 135, 50);
        //Small Logo image
        $this->Image($images[3], 148, 5, 10);
        //G20 images
        $this->Image($images[4], 82, 10, 43);
        $this->Ln(44);
    }

    public function rupeeImage($x, $y, $width) {
        $this->Image('assets/images/rupee.png', $x, $y, $width);
    }

    public function printPortraitData($banks, $customer, $storeDetails, $banks_options, $mortgages, $customers_mortgages) {
        // Add a new page
        $this->AddPage('P', 'a4');
        $this->Rect(2, 2, 205, 292);;
        $banksName = $banks['bank_name'];
        $this->HeaderPortraitImage(array( 'assets/images/logo.jpg',$banks['logo'], 'assets/images/watermarkG20.png', 'assets/images/small_logo.jpg', 'assets/images/G20.png'));
        $this->storeDetails($storeDetails, $banks_options, $banksName, $customers_mortgages['branch_name'], 'P', 10);
        // Column titles given by the programmer
        $header = array('Sr. No', 'Description of  Jewels/Ornaments assessed', 'HallMark', 'No Of Units', 'Fineness % of purity(in Carats)', 'Gross Weight in Grams',
            'Net Weight',  '22 carat Gold content in Grams', 'Approx Value In Rupees');

        $widths = array(8, 32, 16, 20, 30, 16, 23, 18, 30);
        $height = 6;
        $heightMortgage = 6;
        $this->SetWidths($widths);
        $this->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
        $bank = $this->checkBankName($banksName);
        switch ($bank) {
            case 'Canara':
               $y = 107.5;
                break;
            default:
                $y = 137.5;
                break;
        }
        $this->getMortgageData($header, $mortgages, $customers_mortgages, $widths, $height, $heightMortgage, $y);
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
        for($i=0;$i<count($data);$i++)
            $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h = 5*$nb;
        // Issue a page break first if needed
        //$this->CheckPageBreak($h);
        // Draw the cells of the row
        for($i=0;$i<count($data);$i++)
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
