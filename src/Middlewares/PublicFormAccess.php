<?php
/*--------------------
https://github.com/jazmy/laravelformbuilder
Licensed under the GNU General Public License v3.0
Author: Jasmine Robinson (jazmy.com)
Last Updated: 12/29/2018
----------------------*/
namespace jazmy\FormBuilder\Middlewares;

use Closure;
use jazmy\FormBuilder\Models\Form;

class PublicFormAccess
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
        $identifier = $request->route('identifier');

        $form = Form::where('identifier', $identifier)->firstOrFail();

        if ($form->isPrivate()) {
            // the user must be authenticated
            if (! auth()->check()) {
                return redirect()
                            ->route('login')
                            ->with('error', "Form '{$form->name}' requires you to login before you can access it.");
            }
        }

        return $next($request);
    }
}
