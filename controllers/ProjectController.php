<?php

namespace app\controllers;


use Yii;
use app\models\Project;
use yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


class ProjectController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpload()
    {
        $model = new \app\models\Project();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                $name = UploadedFile::getInstance($model,'filename');
                $path = 'uploads/'.md5($name->baseName). '.' .$name->extension;
                if($name->saveAs($path)){
                    $model->filename = $name->baseName . '.' . $name->extension;
                    $model->filepath = $path;
                    if($model->save()){
                        if($name->extension == 'csv')
                        {

                            //return $this->redirect(['index']);

                            $fileName = $path; //CSV file location
                            $delimiter = ","; //CSV delimiter character: , ; /t
                            $enclosure = '"'; //CSV enclosure character: " ' 
                            $password = ''; //Optional to prevent abuse. If set to [your_password] will require the &Password=[your_password] GET parameter to open the file
                            $ignorePreHeader = 0; //Number of characters to ignore before the table header. Windows UTF-8 BOM has 3 characters.
                            //------------------------------------------------
                            
                            //Variable initialization
                            $logLines = array();
                            $tableOutput = "<b>No data loaded</b>";
                            
                            //Verify the password (if set)
                            if($password === ""){
                            
                                    if(file_exists($fileName)){ // File exists
                            
                                    // Reads lines of file to array
                                    $fileLines = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                            
                                    //Not Empty file
                                    if($fileLines !== array()){
                            
                                        //Extract the existing header from the file
                                        $lineHeader = array_shift($fileLines);
                                        $logOriginalHeader = array_map('trim', str_getcsv(substr($lineHeader,$ignorePreHeader), $delimiter, $enclosure));
                            
                                        //Process the file only if the system could find a valid header
                                        if(count($logOriginalHeader) > 0) {			
                                            //Open the table tag
                                            $tableOutput="<TABLE style='min-width: 70%;' class='table table-bordered'>";
                            
                                            //Print the table header
                                            $tableOutput.="<TR style='background-color: lightgray;text-align:center; '>";
                                            $tableOutput.="<TD><B>Row</B></TD>"; 
                                            foreach ($logOriginalHeader as $field)
                                                $tableOutput.="<TD><B>".$field."</B></TD>"; //Add the columns
                                            $tableOutput.="</TR>";
                            
                                            //Get each line of the array and print the table files
                                            $countLines = 0;
                                            foreach ($fileLines as $line) {
                                                if(trim($line) !== ''){ //Remove blank lines
                                                        $countLines++;
                                                        $arrayFields = array_map('trim', str_getcsv($line, $delimiter, $enclosure)); //Convert line to array
                                                        $tableOutput.="<TR><TD style='background-color: lightgray; '>".$countLines."</TD>";
                                                        foreach ($arrayFields as $field)
                                                            $tableOutput.="<TD>".$field."</TD>"; //Add the columns
                                                        $tableOutput.="</TR>";
                                                    }
                                            }
                            
                                            //Print the table footer
                                            $tableOutput.="<TR style='background-color:lightgray; text-align:center; '>";
                                            $tableOutput.="<TD><B>Row</B></TD>";
                                            foreach ($logOriginalHeader as $field)
                                                $tableOutput.="<TD><B>".$field."</B></TD>"; //Add the columns
                                            $tableOutput.="</TR>";
                            
                                            //Close the table tag
                                            $tableOutput.="</TABLE>";
                                        }
                                        else $tableOutput = "<b>Invalid data format</b>";
                                    }
                                    else $tableOutput = "<b>Empty file</b>";
                                }
                                else $tableOutput = "<b>File not found</b>";        
                            }
                            else $tableOutput = "<b>Invalid password.</b> Enter the password using this URL format: ".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."?Password=<b>your_password</b>";
                            
                            return $this->render('csvShow', ['tableData' => $tableOutput,'namaFile'=>$path]); 

                        }if($name->extension == 'xlsx' || $name->extension == 'xls')
                        {
                            $reader = IOFactory::createReader('Xlsx');
                            $spreadsheet = $reader->load($path);
                            $writer = IOFactory::createWriter($spreadsheet, 'Html');

                            return $this->render('excelView', ['show' => $writer,'namaFile'=>$path]);

                        }if($name->extension == 'pdf')
                        {
                            return $this->render('pdfShow', ['namaFile'=>$path]);

                        }if($name->extension == 'doc' || $name->extension == 'docx')
                        {
                            $phpWord = new \PhpOffice\PhpWord\PhpWord();

                            $objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                            $objWriter->save($name->extension + '.pdf');

                            
                           

                            return $this->render('wordShow', ['namaFile'=>$objWriter]);

                        }
                    
                    }
                }
                return;
            }
        }

        return $this->render('upload', [
            'model' => $model,
        ]);
    }
}
