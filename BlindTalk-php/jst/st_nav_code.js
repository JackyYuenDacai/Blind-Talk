﻿ document.write("<nav class=' navbar navbar-default navbar-fixed-top' role='navigation'>     <div class='container'>      <div class='navbar-header'>        <a class='navbar-brand' href='.'>Blind Talk</a>     </div>     <div>         <div class='navbar-collapse collapse'>        <ul class='nav navbar-nav'>           <li id='st_nav_0' ><a href='index.html'>Home</a></li>           <li id='st_nav_1' ><a href='#'>News</a></li>             <li id='st_nav_2' ><a href='signup.html'>Sign Up</a></li>             <li id='st_nav_3' class='dropdown'>              <a href='#' class='dropdown-toggle' data-toggle='dropdown'>                 About                 <b class='caret'></b>              </a>              <ul class='dropdown-menu'>                 <li><a href='#'>About</a></li>                 <li><a href='#'>Developer</a></li>                 <li><a href='#'>Thanks</a></li>                 <li class='divider'></li>                 <li><a href='#'>Help</a></li>              </ul>           </li>           </ul>             <ul class='nav navbar-nav navbar-right '>                  <li  id='st_nav_4' ><a href='login.html'>Login</a></li>               </ul>     </div>         </div>     </div>  </nav>");        if (st_nav_wh != null) {          document.getElementById("st_nav_" + st_nav_wh).className = "active";      }  
