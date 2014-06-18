<!DOCTYPE html>
<html ><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
        <link href="../../ClassicBet-msgCampaigns_files/main.css" rel="stylesheet" type="text/css">
        <link href="../../ClassicBet-msgCampaigns_files/bootstrap.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../../ClassicBet-msgCampaigns_files/font-awesome.css">
        
        <script type="text/javascript" src="../../views/js/harveyjs.js">
        </script>
        
        <script type="text/javascript" >
        $(document).ready(function(){
        $("#t1").hide();   
        $("#hide").click(function(){
            $("#t1").hide();
        });
        $("#show").click(function(){
            $("#t1").show();
        });
        });
        </script>
        
	<title>ClassicBet</title>
    </head>
    
    <body>
        
        <div class="row">
            <div class="col-md-12">
                <div class="widget box">
        <div class="widget-header">
                <h4><i class="icon-reorder"></i> <?= $groupname?> </h4>
               
        </div>
        <div class="widget-content no-padding">
                <table data-display-length="15" data-default-order="1" class="table table-striped table-bordered ">
                        <thead>
                                <tr>
                                        <th class="checkbox-column">
                                                <i class="icon-plus "></i>
                                        </th>											
                                        <th>Group name</th>
                                        <th>firstname</th>
                                        <th>lastname</th>
                                        <th>email</th>
                                        <th>operation</th>
                                </tr>
                        </thead>

                        <tbody>
                            <?php
                             foreach ($groupusers as $user) {
                            ?>
                                <tr>
                                        <td class="checkbox-column">
                                                <i class="icon-folder-open"></i>
                                        </td>
                                        <td><?=$user['groupname']?></td>
                                        <td><?=$user['firstname']?></td>
                                        <td><?=$user['lastname']?></td>
                                        <td><?=$user['email']?></td>
                                        
                                        <td><button onClick="return del_groupmember_sure('<?= $groupname?>','<?=$user['id']?>');" id="delete" name="delete">Remove</button></td>
                                </tr>
                                

                            <?php
                                   }
                            ?>
                                <tr>
                                    <td colspan="6" nowrap>
                                        <form action="../../controllers/listcontroller/save_modified_group.php" method="post" nowrap>

                                     <input type="hidden" value="<?= $groupname?>" name="id"/>
                                     
                                    
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td><input type="submit" id="show" value="save user" />
                                        
                                    </td>
                                </tr>
                                </form>
                        </tbody>
                        
                </table>
        </div>
    </div>
    </div>
            
            
<!--            <form  id="t1">
                <table >
                    <tr>
                        <td>col1</td>
                        <td>col2</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                    </tr>
                </table>
            <input type="button" id="hide" value="hide"/>
            <input type="submit" id="" value="add"/>
           </form>-->
    </body>
</html>