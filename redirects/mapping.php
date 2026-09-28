<?php
  // echo "test mapping.php";
  // exit;

  // Forward subdomains of umple.org (used to be by hover at 64.98.145.30 )
  $query=$_SERVER['QUERY_STRING'];
  $wikip="";
  $manp="";
  $theServer=$_SERVER['HTTP_HOST'];
  switch ($theServer) {

    // Direct legacy connect from  UOttawa
    case "cruise.eecs.uottawa.ca":
      $loc="https://cruise.umple.org/cruise/"; break;

    case "cruise.site.uottawa.ca":
      $loc="https://cruise.umple.org/cruise/"; break;


    // Manual pages and special doc pages
    case "manual.umple.org":
      if($query == "") $manp="GettingStarted.html";
      else { $manp=$query; $query=""; }
      break;

    case "cruise.umple.org":
      if($query == "") {
        $loc="/cruise/"; break;
      }
      // drop through as remainder is same as others at top level

    case "try.umple.org":
      $loc="/umpleonline/";
      break;

    case "new.umple.org":
    case "www.umple.org":
    case "umple.org":
      $path=parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $stringprefix=explode("/", trim($path, "/"))[0];
      switch ($stringprefix) {
        // front page; with a query (?example=...) open UmpleOnline, as cruise does
        case "": $loc = $query == "" ? "/index.html" : "/umpleonline/"; break;

        // critical internal pages
        case "dl": $loc="https://new.umple.org/manual/UmpleTools.html"; break;

        case "try": $loc="/umpleonline/"; break;

        case "jenkins": $loc="https://jenkins.umple.org"; break;

        case "license":
        case "licence":
          $loc="https://github.com/umple/umple/blob/master/LICENSE.md"; break;

        case "uol2": $loc="https://newumpleonline.umple.org"; break;

        case "javadoc": $loc="/umple/umple-compiler-javadoc/overview-tree.html"; break;
        case "metamodel": $loc="/umple/umple-core-classDiagram.shtml"; break;


        // Pages on github
        case "code": 
        case "trunk":
          $loc="https://github.com/umple/umple"; break;

        case "prs":
          if($query !="") $query="/".$query; // convert ? to /
          $loc="https://github.com/umple/umple/pulls"; break;
        case "bugs":
        case "issues":
          $loc="https://github.com/umple/umple/issues"; break;
        case "org":
          $loc="https://github.com/umple/"; break;
        case "lsp":
         // the following gives update required
          $loc="https://github.com/umple/umple-lsp"; break;
        case "zed":
          $loc="https://github.com/umple/umple.zed"; break;
        case "bbedit":
          $loc="https://github.com/umple/umple-lsp/blob/master/editors/bbedit/README.md"; break;
        case "skills":
          $loc="https://github.com/umple/umple-skills"; break;

        case "changed": $loc="https://github.com/umple/Umple/issues?q=is%3Aissue+is%3Aclosed+sort%3Aupdated-desc+"; break;
        case "projects": $loc="https://github.com/orgs/umple/projects"; break;
        case "releases": $loc="https://github.com/umple/umple/releases"; break;
        case "research": $loc="https://github.com/umple/umple/labels/Type-ResearchGrad"; break;

        // Direct access to certain manual pages. case manual is a direct link
        case "privacy": $manp="PrivacyandRisks.html"; break;
        case "grammar": $manp="UmpleGrammar.html"; break;
        case "api": $manp="APISummary.html"; break;
        case "tools": $manp="UmpleTools.html"; break;

        case "adopt": $manp="ConvincingPotentialAdopters.html"; break;
        case "associations": $manp="AssociationDefinition.html"; break;
        case "attributes": $manp="AttributeDefinition.html"; break;
        case "classes": $manp="ClassDefinition.html"; break;
        case "mixsets": $manp="BasicMixsets.html"; break;
        case "motl":
        case "tracing":
          $manp="ModelOrientedTracingLanguage(MOTL).html"; break;
        case "statemachines": $manp="BasicStateMachines.html"; break;
        case "templates":
        case "umpletl":
          $manp="BasicTemplates.html"; break;
        case "traits": $manp="Traits.html"; break;

        // wiki pages
        case "wiki":  $loc="https://github.com/umple/umple/wiki"; break;
        case "cheatsheet":  $loc="https://github.com/umple/Umple/wiki/CheatSheet"; break;
        case "devsetup":  $loc="https://github.com/umple/umple/wiki/DevelopmentSetUp"; break;
        case "architecture":  $loc="https://github.com/umple/umple/wiki/Architecture"; break;
        case "examples":  $loc="https://github.com/umple/Umple/wiki/examples"; break;
        case "philosophy":  $loc="https://github.com/umple/Umple/wiki/PhilosophyAndVision"; break;
        case "publications":  $loc="https://github.com/umple/umple/wiki/Publications"; break;

        // UOttawa donation pages .... need fixing for a real donation site
        case "give":
        case "donate":
        case "giving":
        case "don":
        case "donner":
          $loc="https://www.zeffy.com/en-CA/donation-form/cece69e1-58ce-491c-8575-0f7e70eb9a3c";
          break;

        // Other pages
        case "blog":  $loc="https://tims-ideas.blogspot.com/search/label/Umple"; break;
        case "cc":
        case "appveyor":
          $loc="https://ci.appveyor.com/project/vahdat-ab/umple"; break;
        case "docker":  $loc="https://hub.docker.com/r/umple/umpleonline/"; break;
        case "facebook":  $loc="https://www.facebook.com/umple.org/"; break;
        case "list":  $loc="https://groups.google.com/g/umple"; break;
        case "questions":  $loc="https://stackoverflow.com/questions/tagged/umple"; break;
        case "tcl":  $loc="https://uniweb.uottawa.ca/members/119/profile?embed=2"; break;
        case "linkedin":  $loc="https://www.linkedin.com/groups/13038747/"; break;
        case "twitter":  $loc="https://x.com/umpleorg"; break;
        case "x":  $loc="https://x.com/umpleorg"; break;


/*
        case "test": $loc="https://cruise.umple.org/test/umpleonline/"; break;
        case "umpr": $loc="https://umpr.a4word.com/?"; break;


*/

        // Default page
        default:
          $loc="https://umple.org";

      }
     // end of switch on string following domain
      break;

    default:
       if (strpos($_SERVER['HTTP_HOST'],"umple.org") !== FALSE)
          $loc="https://cruise.umple.org/umple";
       else
          $loc="https://cruise.umple.org/index.shtml";
  }
  if($wikip != "") $loc="https://github.com/umple/Umple/wiki/".$wikip;
  if($manp != "") $loc="/umple/".$manp;

  // prs has already turned the query into a path
  if($query != "" && $query[0] != "/") $query="?".$query;
  header("Location: ".$loc.$query);
  exit;

  // Comment out the above to access the following
  phpinfo();

?>
