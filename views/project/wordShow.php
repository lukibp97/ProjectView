
<!DOCTYPE html>
    <html>
    <head>
    <meta charset="UTF-8"> 
    <title>Document Viewer</title>
    </head>
    <body>
    <h1>Document Viewer</h1>
    <a name="top"></a>
    <hr>
    <table style="width:50%">
    	<tr>
    		<td><a href="" onClick="location.reload()">Refresh</a></td>
    		<td><a href="<?=$namaFile ?>">Download</a></td>
    		<td><a href="#bottom">End</a></td>
    	</tr>
    </table>
    <hr>
    <?php $namaFile->save('php://output'); ?>
    <a name="bottom"></a> 
    <hr>
    <table style="width:50%">
    	<tr>
    		<td><a href="" onClick="location.reload()">Refresh</a></td>
    		<td><a href="<?=$namaFile ?>">Download</a></td>
    		<td><a href="#top">Top</a></td>
    	</tr>
    </table>
    <hr>
    </body>
    </html>