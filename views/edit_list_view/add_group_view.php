<!DOCTYPE html>
<html ><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
        <link href="../../ClassicBet-msgCampaigns_files/main.css" rel="stylesheet" type="text/css">
        <link href="../../ClassicBet-msgCampaigns_files/bootstrap.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../../ClassicBet-msgCampaigns_files/font-awesome.css">
        
        <script type="text/javascript" src="../../views/js/harveyjs.js">
        </script>
	<script type="text/javascript" src="../../views/js/jquery-1.11.1.min.js"></script>
        
        

     <title>ClassicBet</title>
    </head>
    <body>

        
        <form method="post" action="../../controllers/listcontroller/save_new_group.php" id="addgroup">
            
            <div class="row">
            <div class="col-md-12">
                <div class="widget box">

            <div class="widget-header">
                <h4> group name:<input style="padding: 0 !important" type="text" name="filename" /> </h4>
           
           </div>
            
          <div class="widget-content no-padding">
            <table data-display-length="15" data-default-order="1" class="table table-striped table-bordered ">
                <thead>
                    <tr>
                        
                        <th><input type="checkbox" name="selectall" id="selectall" onclick="selectAllCheckBox(this)"/></th>
                        <th>firstname</th>
                        <th>lastname</th>
                        <th>email</th>
                        <th>birth</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                    foreach ($users as $user){
                    ?>
                    <div>
                        <tr>
                            <td><input type="checkbox" name="prikey[]" id= 'prikey[]' value="<?=$user['id']?>" /></td> 
                            <td><?=$user['firstname']?></td>
                            <td><?=$user['lastname']?></td>
                            <td><?=$user['email']?></td>
                            <td><?=$user['birthday']?></td>
                        </tr>
                    </div>
                    <?php
                    }
                    ?>

            
                    <tr>
                        <td colspan="4">
                        <input name="" type="submit" value="save"/>
                        <input id="show" name="show" type="button" value="advanced" />
                       
                        </td>
                    </tr>
                 </tbody>
               </table>
             </div>   
            </div>
          </div>
        </div>
            </form>
    
        
   
       
    </body>
</html>