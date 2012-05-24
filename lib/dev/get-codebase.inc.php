<?php
/** 
 * USAGE
 * You should have an index.php file in your public_html that looks like this:
 * <?php
 * $site_url = strtolower($_SERVER['HTTP_HOST']);
 * $site = str_replace('.MYSITE.COM', '', $site_url);
 *
 * $codebases_path = "/home/MYSITE/codebases/";
 *
 * $sites = json_decode(file_get_contents('sites.json', true));
 * include $codebases_path . end($sites->$site) . '/lib/dev/get-codebase.inc.php';
 *
 * $codebase_path_arr = array();
 *  foreach($sites->$site as $codebase) {
 *      $codebase_path_arr[] = getCodeBase($codebases_path, $codebase);
 * }
 *  $skyphp_storage_path = "/home/MYSITE/storage";
 *  # $down_for_maintenance = true;
 *  include $codebases_path . end($sites->$site) . '/sky.php' ;
 * ?>
 * You must also have a sites.json file with an array of subdomains and codebases in the following format:
 *   {
 *    "dev1": [
 *        "SkyPHP/codebase1/master",
 *        "SkyPHP/codebase1-inc/master",
 *        "SkyPHP/codebase3-inc/master",
 *        "SkyPHP/cms/master",
 *        "SkyPHP/skyphp/master"
 *    ],
 *    "dev2": [
 *        "CoolUser/codebase1/master",
 *        "CoolUser/codebase1-inc/master",
 *        "Skyphp/excel/master",
 *        "SkyPHP/cms/master",
 *        "SkyPHP/skyphp/master"
 *    ],
 * }
 * The format is username/repository/branch
 * More info available at:
 * https://skydev.atlassian.net/wiki/display/SKYPHP/GitHub+PHP+Hook+Setup
 * and
 * https://skydev.atlassian.net/wiki/display/SKYPHP/New+Site+Configuration
 */

/**
 * Clones a codebase into codebase_path from gitHub
 * @param string $codebase_path: where you want the codebase to go
 * @param string $codebase: the codebase on GitHub in username/repository/branch format 
 * @return string $branch_path: the location of the new codebase with a / at the end
 */

function getCodeBase($codebase_path, $codebase) {
    $branch_path = $codebase_path . $codebase;

    //create folder structure and download branch
    if(!is_dir($branch_path)){
        $codebase = explode('/', $codebase);
        $user = $codebase[0];
        $repository = $codebase[1];
        $branch = $codebase[2];

        mkdir($branch_path, 0777, true);
        echo exec("cd $branch_path; git clone -b $branch git@github.com:$user/$repository.git .;");
    }

    return $branch_path . '/';
}