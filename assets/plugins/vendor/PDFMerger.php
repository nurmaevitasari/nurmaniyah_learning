<?php namespace Jurosh\PDFMerge;

use Exception;
use setasign\Fpdi\Fpdi AS FPDI;

/**
 * Basic merging of PDF files into one file
 *
 * TODO: check newer https://github.com/tecnickcom/TCPDF
 */
class PDFMerger {

    /**
     * @var type Array of PDFObject-s
     */
    private $_files;

    /**
     * Add a PDF for inclusion in the merge with a valid file path.
     * Params are defined like array:  
     *  'pages' => '...',
     *  'orientation' => 'vertical / horizontal'
     * 
     * Pages should be formatted: 1,3,6, 12-16.
     * @param $filepath
     * @param $param
     * @return PDFMerger
     */
    public function addPDF($filepath, $pages = 'all', $orientation = 'vertical') {
        if (file_exists($filepath)) {
            $file = new PdfObject;
            
            if (strtolower($pages) != 'all') {
                $file->pages = $this->_rewritepages($pages);
            }
            
            $file->orientation = $orientation;
            $file->path = $filepath;

            $this->_files[] = $file;
        } else {
            throw new Exception("Could not locate PDF on '$filepath'");
        }

        return $this;
    }

    /**
     * Merge it.
     * @param $outputmode
     * @param $outputname
     * @return PDF
     */
    public function merge($outputmode = 'browser', $outputpath = 'newfile.pdf') {
        if (!isset($this->_files) || !is_array($this->_files)) {
            throw new Exception("No PDFs to merge.");
        }

        $fpdi = new FPDI;

        // merger operations
        /* @var $file PdfObject */
        foreach ($this->_files as $file) {
            $filename = $file->path;
            $filepages = $file->pages;

            $count = $fpdi->setSourceFile($filename);

            //add the pages
            if ($filepages == 'all') {
                for ($i = 1; $i <= $count; $i++) {
                    $template = $fpdi->importPage($i);
                    $size = $fpdi->getTemplateSize($template);

                    $fpdi->AddPage($file->getOrientationCode(), array($size['width'], $size['height']));
                    $fpdi->useTemplate($template);
                }
            } else {
                foreach ($filepages as $page) {
                    if (!$template = $fpdi->importPage($page)) {
                        throw new Exception("Could not load page '$page' in PDF '$filename'. Check that the page exists.");
                    }
                    $size = $fpdi->getTemplateSize($template);

                    $fpdi->AddPage($file->getOrientationCode(), array($size[0], $size[1]));
                    $fpdi->useTemplate($template);
                }
            }
        }

        //output operations
        $mode = $this->_switchmode($outputmode);

        if ($mode == 'S') {
            return $fpdi->Output($outputpath, 'S');
        } else {
            if ($fpdi->Output($outputpath, $mode) == '') {
                return true;
            } else {
                throw new Exception("Error outputting PDF to '$outputmode'.");
                return false;
            }
        }
    }

    /**
     * FPDI uses single characters for specifying the output location. Change our more descriptive string into proper format.
     * @param $mode
     * @return Character
     */
    private function _switchmode($mode) {
        switch (strtolower($mode)) {
            case 'download':
                return 'D';
                break;
            case 'browser':
                return 'I';
                break;
            case 'file':
                return 'F';
                break;
            case 'string':
                return 'S';
                break;
            default:
                return 'I';
                break;
        }
    }

    /**
     * Takes our provided pages in the form of 1,3,4,16-50 and creates an array of all pages
     * @param $pages
     * @return unknown_type
     */
    private function _rewritepages($pagesParam) {
        $pages = str_replace(' ', '', $pagesParam);
        $part = explode(',', $pages);

        //parse hyphens
        foreach ($part as $i) {
            $ind = explode('-', $i);

            if (count($ind) == 2) {
                $x = $ind[0]; //start page
                $y = $ind[1]; //end page

                if ($x > $y) {
                    throw new Exception("Starting page, '$x' is greater than ending page '$y'.");
                    return false;
                }

                //add middle pages
                while ($x <= $y) {
                    $newpages[] = (int) $x;
                    $x++;
                }
            } else {
                $newpages[] = (int) $ind[0];
            }
        }
        return $newpages;
    }


    ////mayoriii

            public function add( $filename ){
            $f = @fopen($filename, 'rb');
            if (!$f) {
                $this->error('impossible d\'ouvrir le fichier');
            }
            fseek($f, 0, SEEK_END);
            $fileLength = ftell($f);
            
            // Localisation de xref
            //-------------------------------------------------
            
            fseek($f, -128, SEEK_END);
            $data = fread($f, 128);
            if ($data === false) {
                return $this->error('erreur de lecture dans le fichier');
            }
            $p = strripos($data, 'startxref');
            if ($p === false){
                return $this->error('startxref absent');
            }
            $startxref = substr($data, $p+10, strlen($data) - $p - 17);
            $posStartxref = $fileLength - 128 + $p;
            
            // extraction de xref + trailer
            //-------------------------------------------------
            
            fseek($f, $startxref);
            $data = fread($f, $posStartxref - $startxref);
            
            // extraction du trailer
            //-------------------------------------------------
            $p = stripos($data, 'trailer');
            if ($p === false){
                return $this->error('trailer absent');
            }
            $dataTrailer = substr($data, $p + 8);
            $len = strlen($dataTrailer);
            $off = 0;
            $trailer = $this->parse($dataTrailer, $len, $off);
            
            // extraction du xref
            //-------------------------------------------------
            
            $data = explode("\n", trim(substr($data, 0, $p)));
            array_shift($data); // "xref"
            
            $cnt = 0;
            $xref = array();
            
            foreach($data as $line){
                if (!$cnt) {
                    if (preg_match('`^([0-9]+) ([0-9]+)$`', $line, $m)){
                        $index = intval($m[1]) - 1;
                        $cnt = intval($m[2]);
                    } else {
                        $this->error('erreur dans xref');
                    }
                } else {
                    $index++;
                    $cnt--;
                    if (preg_match('`^([0-9]{10}) [0-9]{5} ([n|f])`', $line, $m)){
                        if ($m[2] === 'f') {
                            continue;
                        }
                        $xref[ $index ] = $m[1];
                    } else {
                        $this->error('erreur dans xref : ' . $line);
                    }
                }
            }
            
            // Lecture des pages
            //-------------------------------------------------

            $root = $this->getObject($f, $xref, $trailer[1]['/Root'][1]);
            $root = $root[1][1];
            
            $pages = $this->getObject($f, $xref, $root['/Pages'][1]);
            $pages = $pages[1][1];
            
            foreach($pages['/Kids'][1] as $kid){
                $kid = $this->getObject($f, $xref, $kid[1]);
                $kid = $kid[1];
                
                $resources = $this->getResources($f, $xref, $kid);
                $resources = $resources[1][1];
                
                $content = $this->getContent($f, $xref, $kid);
                
                // traitement des fonts
                //-------------------------------------------------
                $newFonts = array();
                if (isset($resources['/Font']) && !empty($resources['/Font'])){
                    if (preg_match_all("`(/F[0-9]+)\s+-?[0-9\.]+\s+Tf`", $content, $matches, PREG_OFFSET_CAPTURE)){
                        $newContent = '';
                        $offset     = 0;
                        $cnt = count($matches[0]);
                        for($i=0; $i<$cnt; $i++){
                            $position = $matches[0][$i][1];
                            $name     = $matches[1][$i][0];
                            if (!isset($newFonts[$name])){
                                $object = $this->getObject($f, $xref, $resources['/Font'][1][$name][1], true);
                                $newFonts[$name] = $this->storeObject($object, '/Font');
                            }
                            if ($newFonts[$name] !== $name){
                                $newContent .= substr($content, $offset, $position - $offset);
                                $newContent .= $newFonts[$name];
                                $offset = $position + strlen($name);
                            }
                        }
                        $content = $newContent . substr($content, $offset);
                    }
                }
                
                // traitement des XObjets
                //-------------------------------------------------
                $newXObjects = array();
                if (isset($resources['/XObject']) && !empty($resources['/XObject'])){
                    if (preg_match_all("`(/[^%\[\]<>\(\)\r\n\t/]+) Do`", $content, $matches, PREG_OFFSET_CAPTURE)){
                        $newContent = '';
                        $offset     = 0;
                        foreach($matches[1] as $m){
                            $name = $m[0];
                            $position = $m[1];
                            if (!isset($newXObjects[$name])){
                                $object = $this->getObject($f, $xref, $resources['/XObject'][1][$name][1], true);
                                $newXObjects[$name] = $this->storeObject($object, '/XObject');
                            }
                            if ($newXObjects[$name] !== $name){
                                $newContent .= substr($content, $offset, $position - $offset);
                                $newContent .= $newXObjects[$name];
                                $offset = $position + strlen($name);
                            }
                        }
                        $content = $newContent . substr($content, $offset);
                    }
                }

                $mediaBox = isset($kid[1]['/MediaBox']) ? $kid[1]['/MediaBox'] : (isset($pages['/MediaBox']) ? $pages['/MediaBox'] : null);
            
                if ($mediaBox[0] !== self::TYPE_ARRAY){
                    $this->error('MediaBox non definie');
                }
                
                
                $this->pages[] = array(
                    'content'   => $content,
                    '/XObject'  => array_values($newXObjects),
                    '/Font'     => array_values($newFonts),
                    '/MediaBox' => $mediaBox
                );
            }
            fclose($f);
        }
        
        public function output($filename = null){
            $this->_out('%PDF-1.6');
            
            $this->_putObjects();
            
            $rsRef = $this->_putResources();
            
            $ptRef = $this->_newobj(true);
            
            $kids = array();
            
            // Ajout des pages 
            $n = count($this->pages);
            for($i=0; $i<$n; $i++){
                $ctRef = $this->_addObj(array(), $this->pages[$i]['content']);
                $dico = array(
                    '/Type'     => array(self::TYPE_TOKEN, '/Page'),
                    '/Parent'   => array(self::TYPE_REFERENCE, $ptRef),
                    '/MediaBox' => $this->pages[$i]['/MediaBox'],
                    '/Resources'=> array(self::TYPE_REFERENCE, $rsRef),
                    '/Contents' => array(self::TYPE_REFERENCE, $ctRef),
                );
                $kids[] = array(self::TYPE_REFERENCE, $this->_addObj($dico));
            }
            
            // Ajout du page tree
            $ptDico = array(
                self::TYPE_DICTIONARY,
                array(
                    '/Type'     => array(self::TYPE_TOKEN, '/Pages'),
                    '/Kids'     => array(self::TYPE_ARRAY, $kids),
                    '/Count'    => array(self::TYPE_NUMERIC, count($kids))
                )
            );
            
            $this->_newobj($ptRef);
            $this->_out($this->_toStream($ptDico));
            $this->_out('endobj');
            
            // Ajout du catalogue
            $ctDico = array(
                self::TYPE_DICTIONARY,
                array(
                    '/Type' => array(self::TYPE_TOKEN, '/Calalog'),
                    '/Pages'=> array(self::TYPE_REFERENCE, $ptRef)
                    )
            );
            $ctRef = $this->_newobj();
            $this->_out($this->_toStream($ctDico));
            $this->_out('endobj');
            
            // Ajout du xref
            $xrefOffset = strlen($this->buffer);
            $count = count($this->xref);
            $this->_out('xref');
            $this->_out('0 ' . ($count+1));
            $this->_out('0000000000 65535 f ');
            for($i=0; $i<$count; $i++){
                $this->_out(sprintf('%010d 00000 n ',$this->xref[$i+1]));
            }
            
            // Ajout du trailer
            $dico = array(
                '/Size' => array(self::TYPE_NUMERIC, 1+count($this->xref)),
                '/Root' => array(self::TYPE_REFERENCE, $ctRef)
            );
            $this->_out('trailer');
            $this->_out($this->_toStream(array(self::TYPE_DICTIONARY, $dico)));
            
            
            // Ajout du startxref
            $this->_out('startxref');
            $this->_out($xrefOffset);
            $this->_out('%%EOF');
            
            if ($filename === null){
                header('Content-Type: application/pdf');
                header('Content-Length: '.strlen($this->buffer));
                header('Cache-Control: private, max-age=0, must-revalidate');
                header('Pragma: public');
                ini_set('zlib.output_compression','0');
                
                echo $this->buffer;
                die;
            } else {
                file_put_contents($filename, $this->buffer);
            }
        }

}
