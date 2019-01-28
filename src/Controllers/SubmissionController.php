<?php
/*--------------------
https://github.com/jazmy/laravelformbuilder
Licensed under the GNU General Public License v3.0
Author: Jasmine Robinson (jazmy.com)
Last Updated: 12/29/2018
----------------------*/
namespace jazmy\FormBuilder\Controllers;

use App\Http\Controllers\Controller;
use jazmy\FormBuilder\Helper;
use jazmy\FormBuilder\Models\Form;
use jazmy\FormBuilder\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param integer $form_id
     * @return \Illuminate\Http\Response
     */
    public function index($form_id)
    {
        $user = auth()->user();

        $form = Form::where(['user_id' => $user->id, 'id' => $form_id])
                    ->with(['user'])
                    ->firstOrFail();

        $submissions = $form->submissions()
                            ->with('user')
                            ->latest()
                            ->paginate(100);

        // get the header for the entries in the form
        $form_headers = $form->getEntriesHeader();

        $pageTitle = "Submitted Entries for '{$form->name}'";

        return view(
            'formbuilder::submissions.index',
            compact('form', 'submissions', 'pageTitle', 'form_headers')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $form_id
     * @param integer $submission_id
     * @return \Illuminate\Http\Response
     */
    public function show($form_id, $submission_id)
    {
        $submission = Submission::with('user', 'form')
                            ->where([
                                'form_id' => $form_id,
                                'id' => $submission_id,
                            ])
                            ->firstOrFail();

        $form_headers = $submission->form->getEntriesHeader();

        $pageTitle = "View Submission";

        return view('formbuilder::submissions.show', compact('pageTitle', 'submission', 'form_headers'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $form_id
     * @param int $submission_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($form_id, $submission_id)
    {
        $submission = Submission::where(['form_id' => $form_id, 'id' => $submission_id])->firstOrFail();
        $submission->delete();

        return redirect()
                    ->route('formbuilder::forms.submissions.index', $form_id)
                    ->with('success', 'Submission successfully deleted.');
    }
}
