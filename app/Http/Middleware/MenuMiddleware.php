<?php

namespace App\Http\Middleware;

use App\Models\MenuItem;
use Closure;

class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        //$response = $next($request);
        //dd(auth()->check());
        if(auth()->check()){
            \Menu::make('MyNavBar', function($menu){

                //dd(auth()->user()->role_id);
                $menus =  MenuItem::tree(auth()->user()->role_id);//pass logged in user role id
//            dd(MenuItem::tree()->where('activeflag','!=',0));
                if($menus){
                    foreach ($menus as $menuitem){
                        if($menuitem['children'] && count($menuitem['children'])>=1){
                            // if($menuitem->activeflag==1) {
                            $menuvar = $menu->add($menuitem->menuname, array('url' => $menuitem->nodeurl, 'title' => $menuitem->pagetitle, 'class' => 'treeview'))
                                ->prepend($menuitem->glyphicon)->append('<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>');
//                            $menuvar->link->attr(array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));
                            $menuvar->link->attr(array('href' => '#'));
                            // }
                            if($menuitem['children'])
                                foreach ($menuitem['children'] as $child){
                                    if($child->activeflag==1)
                                        $menuvar->add($child->menuname,array('url'=>$child->nodeurl,'title'=>$child->pagetitle))->prepend($child->glyphicon);
                                }
                        }
                        else{
                            //if($menuitem->activeflag==1)
                            $menu->add($menuitem->menuname,array('url'=>$menuitem->nodeurl,'title'=>$menuitem->pagetitle))->prepend($menuitem->glyphicon);
                        }
                    }
                }

//                dd($menus);
            });

            return $next($request);
        }
        else{
            //var_dump('not logged on');
            return $next($request);}
    }
}


//            if($menus){
//                foreach ($menus as $menuitem){
////                    $menu->add($menuitem->menuname,array($menuitem->nodeurl,'class'=>'nav nav-tabs'))->attr('class','nav nav-pills');
//                    if(count($menuitem['children'])>1){
//                        //$menu->add($menuitem->menuname,array('url'=>$menuitem->nodeurl,'title'=>$menuitem->pagetitle))->attr('role','presentation','class','active menu-level-0 dropdown');
//                        $menu=$menu->add($menuitem->menuname,array('url'=>$menuitem->nodeurl,'title'=>$menuitem->pagetitle))->attr('role','presentation','class','active menu-level-0 dropdown');
//                        //$menu->append('<ul>');
//                        //$menu->append('<ul>');
//                        //$menu->add($menuitem->menuname,$menuitem->nodeurl);
//                        $childcount = 1;
//                        $childrennumber = $menuitem['children']->count();
//                        foreach ($menuitem['children'] as $child){
////                            if($childrennumber == 1){
////                                $menu->add($child->menuname,array('url'=>$child->nodeurl,'title'=>$child->pagetitle))->prepend('<ul>')->append('</ul>');
////                                return;
////                            }
//                            if($childcount == 1){
//                                //die($child->first);
////                                $menu->add($child->menuname,array('url'=>$child->nodeurl,'title'=>$child->pagetitle))->prepend('<ul>');
//                                //$menu->append(' Append before first child ');
//                                $menu->add($child->menuname,array('url'=>$child->nodeurl,'title'=>$child->pagetitle));
////                                $menu->add($child->menuname,array('url'=>$child->nodeurl,'title'=>$child->pagetitle))->prepend(' Child '.$childcount++.' of '.$menuitem['children']->count().' children ');
////                                $childcount++;
//                            }
//                            elseif($childcount == $childrennumber){
////                              $menu->add($child->menuname,array('url'=>$child->nodeurl,'title'=>$child->pagetitle))->append('</ul>');
//                              $menu->add($child->menuname,array('url'=>$child->nodeurl,'title'=>$child->pagetitle));
//                                // $menu->add($child->menuname,array('url'=>$child->nodeurl,'title'=>$child->pagetitle))->append(' Child '.$childcount++.' of '.$menuitem['children']->count().' children ');
////                                $childcount++;
//                                //return;
//                            }
//                            else{
//                             $menu->add($child->menuname,array('url'=>$child->nodeurl,'title'=>$child->pagetitle));
////                             $menu->add($child->menuname,array('url'=>$child->nodeurl,'title'=>$child->pagetitle))->append(' Child '.$childcount++.' of '.$menuitem['children']->count().' children ');
////                                $childcount++;
//                            }
//                            $childcount+1;
//                        }
//                        $menu->append('</ul>');
//                    }
//                    else{
////                        $menu->add($menuitem->menuname,array('url'=>$menuitem->nodeurl,'title'=>$menuitem->pagetitle))->attr('role','presentation','class','menu-level-0')->append(' <b>Single parent</b> ');
//                        $menu->add($menuitem->menuname,array('url'=>$menuitem->nodeurl,'title'=>$menuitem->pagetitle))->attr('role','presentation','class','menu-level-0');
//                    }
//                }
////                $menu->append('</ul>');
//            }


