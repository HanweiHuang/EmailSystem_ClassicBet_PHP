<!DOCTYPE html>
<html ><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
        <link href="../../views/ClassicBet-msgCampaigns_files/main.css" rel="stylesheet" type="text/css">
        <link href="../../views/ClassicBet-msgCampaigns_files/bootstrap.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../../views/ClassicBet-msgCampaigns_files/font-awesome.css">
	<title>ClassicBet</title>
    </head>
    <body>
        
        
         <div class="row">
            <div class="col-md-12">
                <div class="widget box">
        <div class="widget-header">
                <h4><i class="icon-reorder"></i> confirm_information </h4>
                <div class="toolbar no-padding">
                        <div class="btn-group">
                            <span class="btn btn-xs widget-collapse">
                                
                            </span>
                        </div>
                </div>
        </div>
                    
        <div class="widget-content no-padding">
                <table data-display-length="15" data-default-order="1" class="table table-striped table-bordered ">
<!--                        <thead>
                                <tr>
                                        <th class="checkbox-column">
                                                <i class="icon-plus "></i>
                                        </th>											
                                        <th>Group name</th>
                                
                                </tr>
                        </thead>-->
                    <form action="../../controller/send_email_controller.php" method="post">
                      
                        <tbody>
                                <tr> 
                                    <td class="checkbox-column" style="width: 15%">
                                                <i class="icon-folder-open"></i>
                                        </td>
                                        <td style="width: 33%"> send_method
                                        </td>
                                        <td><?=$select_method?></td>
                                        
                                </tr>
                                
                                 <tr> 
                                    <td class="checkbox-column" style="width: 15%">
                                                <i class="icon-folder-open"></i>
                                        </td>
                                        <td style="width: 33%"> campaign_name
                                        </td>
                                        <td><?=$campaign_name?></td>
                                        
                                </tr>
                   
                               <tr> 
                                    <td class="checkbox-column" style="width: 15%">
                                                <i class="icon-folder-open"></i>
                                        </td>
                                        <td style="width: 33%"> template_name
                                        </td>
                                        <td><?=$template_name?></td>
                                        
                                </tr>
                                <tr> 
                                    <td class="checkbox-column" style="width: 15%">
                                                <i class="icon-folder-open"></i>
                                        </td>
                                        <td style="width: 33%"> template_content
                                        </td>
                                        <td><?=$content_view?>
                                            <br>
                                            <br>
                                            <h5><?=$rec_mismatch?><h5>
                                        </td>
                                        
                                </tr>
                                 <tr> 
                                    <td class="checkbox-column" style="width: 15%">
                                                <i class="icon-folder-open"></i>
                                        </td>
                                        <td style="width: 33%"> select_group
                                        </td>
                                        <td><?=$select_group?></td>
                                        
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="submit" value="confirm" />
                                        <input type="button" value="cancel" onclick="javascript:document.onload=window.close();"/>
                                    </td>
                                </tr>
                        </tbody>
                       
                        <input type="hidden" name="select_template" value="<?=$select_template?>"/>
                        <input type="hidden" name="template_name" value="<?=$template_name?>"/>
                        <input type="hidden" name="textarea_template" value="<?=$template_content?>"/>
                        <input type="hidden" name="select_users" value="<?=$select_group?>"/>
                        <input type="hidden" name="campaign_name" value="<?=$campaign_name?>"/>
                      </form>
                </table>
        </div>
    </div>
    </div>            
    </body>
    
</html>