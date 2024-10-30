<? 

    if ( ! defined( 'ABSPATH' ) ) exit; 

    if ( current_user_can( 'upload_files' ) ) {
    global $wpdb; 
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { if (isset($_POST['btncheck'])) {
        $postsdatabyte = $wpdb->get_var(" SELECT data_free FROM INFORMATION_SCHEMA.TABLES WHERE table_name = '{$wpdb->prefix}posts'");
        $termsdatabyte = $wpdb->get_var(" SELECT data_free FROM INFORMATION_SCHEMA.TABLES WHERE table_name = '{$wpdb->prefix}term_relationships'");
        $commentsdatabyte = $wpdb->get_var(" SELECT data_free FROM INFORMATION_SCHEMA.TABLES WHERE table_name = '{$wpdb->prefix}commentmeta'");
        $postmetadatabyte = $wpdb->get_var(" SELECT data_free FROM INFORMATION_SCHEMA.TABLES WHERE table_name = '{$wpdb->prefix}postmeta'");
        $optionsdatabyte = $wpdb->get_var(" SELECT data_free FROM INFORMATION_SCHEMA.TABLES WHERE table_name = '{$wpdb->prefix}options'");
        $postsdataarea = '<p class="d-block" style="font-size:12px; color:#21a424;">Total OverHead: ' . $postsdatabyte . ' Byte </p>';
        $termsdataarea = '<p class="d-block" style="font-size:12px; color:#21a424;">Total OverHead: ' . $termsdatabyte . ' Byte </p>';
        $commentsdataarea = '<p class="d-block" style="font-size:12px; color:#21a424;">Total OverHead: ' . $commentsdatabyte . ' Byte </p>';
        $postmetadataarea = '<p class="d-block" style="font-size:12px; color:#21a424;">Total OverHead: ' . $postmetadatabyte . ' Byte </p>';
        $optionsdataarea = '<p class="d-block" style="font-size:12px; color:#21a424;">Total OverHead: ' . $optionsdatabyte . ' Byte </p>'; } }
        
        if($_POST) {
    
        if(isset($_POST["logytia_revisions_check"])) {
            $logytiacleanrevisions = "DELETE FROM {$wpdb->prefix}posts WHERE post_type='revision'";
            $logytiarevisions = $wpdb->query($logytiacleanrevisions);
            $optimizeposts = $wpdb->query("OPTIMIZE TABLE `{$wpdb->prefix}posts`");
            if($logytiarevisions) { $revisuccess = '<p class="d-block" style="font-size:12px; color:#21a424;"> Revizions Cleaned And Table Optimized! </p>';}
            else{$revielse = '<p class="d-block" style="font-size:12px; color:#21a424;"> Revizions Cleaned And Table Optimized! </p>';}}
            
        if(isset($_POST["logytia_draft_posts_check"])) {
            $logytiacleandraft = "DELETE FROM {$wpdb->prefix}posts WHERE post_status = 'draft'";
            $logytiadraft = $wpdb->query($logytiacleandraft);
            $optimizeposts = $wpdb->query("OPTIMIZE TABLE `{$wpdb->prefix}posts`");
            if($logytiadraft) { $draftsuccess =  '<p class="d-block" style="font-size:12px; color:#21a424;"> Draft Posts Cleaned And Table Optimized! </p>';} 
            else{$draftelse = '<p class="d-block" style="font-size:12px; color:#21a424;"> Draft Posts Cleaned And Table Optimized! </p>';}}
            
        if(isset($_POST["logytia_trash_posts_check"])) {
            $logytiacleantrash = "DELETE FROM {$wpdb->prefix}posts WHERE post_status = 'trash'";
            $logytiatrash = $wpdb->query($logytiacleantrash);
            $optimizeposts = $wpdb->query("OPTIMIZE TABLE `{$wpdb->prefix}posts`");
            if($logytiatrash) { $trashsuccess = '<p class="d-block" style="font-size:12px; color:#21a424;"> Trash Posts Cleaned And Table Optimized! </p>';}
            else{$trashelse = '<p class="d-block" style="font-size:12px; color:#21a424;"> Trash Posts Cleaned And Table Optimized! </p>'; }}
        
        if(isset($_POST["logytia_broken_tables_check"])) {
            $logytiacleanbroken = "DELETE FROM {$wpdb->prefix}term_relationships WHERE NOT EXISTS ( SELECT * FROM wp_posts WHERE {$wpdb->prefix}term_relationships.object_id = {$wpdb->prefix}posts.ID)";
            $logytiabroken = $wpdb->query($logytiacleanbroken);
            $optimizeterms = $wpdb->query("OPTIMIZE TABLE `{$wpdb->prefix}term_relationships`");
            if($logytiabroken) { $brokensuccess = '<p class="d-block" style="font-size:12px; color:#21a424;"> Broken Tables Cleaned And Table Optimized! </p>';}
            else{$brokenelse = '<p class="d-block" style="font-size:12px; color:#21a424;"> Broken Tables Cleaned And Table Optimized! </p>';}}
        
        if(isset($_POST["logytia_spam_comments_check"])) {
            $logytiacleanspams = "DELETE FROM {$wpdb->prefix}commentmeta WHERE comment_id NOT IN ( SELECT comment_id FROM wp_comments )";
            $logytiaspams = $wpdb->query($logytiacleanspams);
            $optimizecomments = $wpdb->query("OPTIMIZE TABLE `{$wpdb->prefix}commentmeta`");
            if($logytiaspams) { $spamssuccess =  '<p class="d-block" style="font-size:12px; color:#21a424;"> Spam Comments Cleaned And Table Optimized! </p>';}
            else{$spamselse =  '<p class="d-block" style="font-size:12px; color:#21a424;"> Spam Comments Cleaned And Table Optimized! </p>';}}
            
        if(isset($_POST["logytia_postmeta_trash_check"])) {
            $logytiacleanpostmetaA = "DELETE {$wpdb->prefix}postmeta FROM wp_postmeta LEFT JOIN wp_posts ON ({$wpdb->prefix}postmeta.post_id = {$wpdb->prefix}posts.ID) WHERE ({$wpdb->prefix}posts.ID IS NULL)";
            $logytiacleanpostmetaB = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key IN ('_edit_lock','_edit_last');";
            $logytiapostmeta = $wpdb->query($logytiacleanpostmetaA, $logytiacleanpostmetaB);
            $optimizepostmeta = $wpdb->query("OPTIMIZE TABLE `{$wpdb->prefix}postmeta`");
            if($logytiapostmeta) { $postmetasuccess = '<p class="d-block" style="font-size:12px; color:#21a424;"> Postmeta Trash Cleaned And Table Optimized! </p>';}
            else{$postmetaelse = '<p class="d-block" style="font-size:12px; color:#21a424;"> Postmeta Trash Cleaned And Table Optimized! </p>';}}    
        
        if(isset($_POST["logytia_transient_options_check"])) {
            $logytiacleanoptionA = "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE ('_transient_%');";
            $logytiacleanoptionB = "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE ('_transient%_feed_%');";
            $logytiaoption = $wpdb->query($logytiacleanoptionA, $logytiacleanoptionB);
            $optimizeoptions = $wpdb->query("OPTIMIZE TABLE `{$wpdb->prefix}options`");
            if($logytiaoption) { $optionsuccess = '<p class="d-block" style="font-size:12px; color:#21a424;"> Options Table Transient Cleaned And Table Optimized! </p>';}
            else{$optionelse = '<p class="d-block" style="font-size:12px; color:#21a424;"> Options Table Transient Cleaned And Table Optimized! </p>';}}  
            
        if(isset($_POST["logytia_post_table_check"])) {
            $logytiacleanposttrashA = "DELETE {$wpdb->prefix}posts FROM wp_posts LEFT JOIN wp_posts child ON ({$wpdb->prefix}posts.post_parent = child.ID) WHERE ({$wpdb->prefix}posts.post_parent <> 0) AND (child.ID IS NULL);";
            $logytiacleanposttrashB = "DELETE pm FROM {$wpdb->prefix}postmeta pm LEFT JOIN wp_posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL;";
            $logytiapoststable = $wpdb->query($logytiacleanposttrashA, $logytiacleanposttrashB);
            $optimizeposts = $wpdb->query("OPTIMIZE TABLE `{$wpdb->prefix}posts`");
            if($logytiapoststable) { $poststablesuccess = '<p class="d-block" style="font-size:12px; color:#21a424;"> Posts Table Cleaned And Table Optimized! </p>';}
            else{$poststableelse = '<p class="d-block" style="font-size:12px; color:#21a424;"> Posts Table Cleaned And Table Optimized! </p>';}}
        }
        
?>
    <div class="container-fluid">
		<div class="row">
			<div class="col-12 d-flex flex-column align-items-center position-relative">
			    <form id="logytia_clean_form" action="" method="POST">
			        <? echo '<div id="logytialogo"><img src="' . plugins_url('logytia-simple-db-cleaner/assets/images/logytia-logo.png') . '"></div>'; ?>
		            <div id="logytia_clean_content">
			            <div id="logytia_db_information"><label for="logytia_revisions_check">Clean Revisions</label>
			            <input type="checkbox" id="logytia_revisions_check_one_id" name="logytia_revisions_check"><? echo $postsdataarea, $revisuccess, $revielse; ?></div>
			            <div id="logytia_revisions_check_description"><p>[The WordPress revisions system stores a record of each saved draft or published update. Therefore, a large load occurs in the database. It is recommended that you clean the revisions ]</p></div>
		            </div>
		            <div id="logytia_clean_content">
			             <div id="logytia_db_information"><label for="logytia_draft_posts_check">Draft Posts</label>
			            <input type="checkbox" id="logytia_draft_posts_check_id" name="logytia_draft_posts_check"><? echo $postsdataarea, $draftsuccess, $draftelse; ?></div>
			            <div id="logytia_draft_posts_check_description"><p>[You can clear your accumulated draft posts WARNİNG: Do not check this option if you want to keep your draft posts.]</p></div>
		            </div>
		            <div id="logytia_clean_content">
			             <div id="logytia_db_information"><label for="logytia_trash_posts_check">Trash Posts</label>
			            <input type="checkbox" id="logytia_trash_posts_check_id" name="logytia_trash_posts_check"><? echo $postsdataarea, $trashsuccess, $trashelse; ?></div>
			            <div id="logytia_trash_posts_check_description"><p>[You can clear your accumulated trash posts WARNİNG: Do not check this option if you want to keep your trash posts.]</p></div>
		            </div>
		            <div id="logytia_clean_content">
			             <div id="logytia_db_information"><label for="logytia_broken_tables_check">Broken Tables</label>
			            <input type="checkbox" id="logytia_broken_tables_check_id" name="logytia_broken_tables_check"><? echo $termsdataarea, $brokensuccess, $brokenelse; ?></div>
			            <div id="logytia_broken_tables_check_description"><p>[Delete broken, unrelated data between tables in a WordPress database.]</p></div>
		            </div>
		            <div id="logytia_clean_content">
			             <div id="logytia_db_information"><label for="logytia_spam_comments_check">Spam Comments</label>
			            <input type="checkbox" id="logytia_spam_comments_check_id" name="logytia_spam_comments_check"><? echo $commentsdataarea, $spamssuccess, $spamselse; ?></div>
			            <div id="logytia_spam_comments_check_description"><p>[Clean up all spam comments.]</p></div>
		            </div>
		            <div id="logytia_clean_content">
			            <div id="logytia_db_information"><label for="logytia_postmeta_trash_check">Postmeta Trash</label>
			            <input type="checkbox" id="logytia_postmeta_trash_check_id" name="logytia_postmeta_trash_check"><? echo $postmetadataarea, $postmetasuccess, $postmetaelse; ?></div>
			            <div id="logytia_postmeta_trash_check_description"><p>[Clean up trash in the postmeta table]</p></div>
		            </div>
		            <div id="logytia_clean_content">
			             <div id="logytia_db_information"><label for="logytia_transient_options_check">Transient Options</label>
			            <input type="checkbox" id="logytia_transient_options_check_id" name="logytia_transient_options_check"><? echo $optionsdataarea, $optionsuccess, $optionelse; ?></div>
			            <div id="logytia_transient_options_check_description"><p>[Delete unnecessary entries in the wp_options table named transient.]</p></div>
		            </div>
		            <div id="logytia_clean_content">
			             <div id="logytia_db_information"><label for="logytia_post_table_check">Posts Table Trash</label>
			            <input type="checkbox" id="logytia_post_table_check_id" name="logytia_post_table_check"><? echo $postsdataarea, $poststablesuccess, $poststableelse; ?></div>
			            <div id="logytia_post_table_check_description"><p>[Delete broken, unrelated data between tables in a WordPress Posts database.]</p></div>
		            </div>
		            <input type="submit" class="mt-2" id="buttonclasslogytia" value="Clean!">
	            </form>
	            <form id='checkbuttonform' action='' method='post'>  <input type="submit" id="buttonclasslogytia" name="btncheck" value="Check Total OverHead!"> </form>
			</div>
	    </div>
    </div>	
    
    <? } ?>
