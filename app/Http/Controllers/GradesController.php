<?php
namespace App\Http\Controllers;
use Request;
use App\Grade;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateGradeRequest;
use Session;

class GradesController extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {
        $search_name = Request::get('search_name');
        $search_description = Request::get('search_description');

        if($search_name != ''){
            $counter = Grade::where('name_grade','like','%'.$search_name.'%')->count();
            $grades = Grade::where('name_grade','like','%'.$search_name.'%')->orderBy('name_grade')->paginate($counter);}

        elseif($search_description != ''){
            $counter = Grade::where('description','like','%'.$search_description.'%')->count();
            $grades = Grade::where('description','like','%'.$search_description.'%')->orderBy('name_grade')->paginate($counter);}

        else{
            $counter = Grade::count();
            $grades = Grade::latest()->paginate(30);}

    // Zwrócenie wyniku
        return view('grades.index')->with('grades', $grades)->with('counter', $counter);

    }

//Wyświetla pojedynczą pozycję
	public function show($id)
	{
		$grade = Grade::findOrFail($id);
		return view('grades.show')->with('grade', $grade);
	}

//Tworzenie nowego elemetu
	public function create()
	{
		return view('grades.create');
	}

//Zapisanie dodanego elementu
	public function store(CreateGradeRequest $request)
	{
		$this->validate($request, [
            'name_grade' 		=> 'required|max:50|min:2|unique:grades,name_grade|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-_\. ]{2,})$/',
            'description'       => 'max:250|min:5|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\(\)\+\-.,:;=?!@&#%\[\]\/\^\$" ]{5,})$/',
   		 ]);

		Grade::create($request->all());

        Session::flash('mes_grade_add', 'Gatunek został  oprawnie dodany');

        //przekierowanie po udanej operacji
		return redirect('grades');
	}

// Edycja elementu
	public function edit($id)
	{
		$grade = Grade::findOrFail($id);
		return view('grades.edit')->with('grade', $grade);
	}

//Zapisanie edytowanego elementu
	public function update(CreateGradeRequest $request, $id)
	{
		$this->validate($request, [
        	'name_grade' 		=> 'required|max:50|min:2|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-_\. ]{2,})$/',
            'description'       => 'max:250|min:5|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\(\)\+\-.,:;=?!@&#%\[\]\/\^\$" ]{5,})$/',
   		 ]);

		$grade = Grade::findOrFail($id);
		$grade->update($request->all());
        Session::flash('mes_grade_update', 'Zmiany został poprawie zapisane'); 
        return view('grades.show')->with('grade', $grade);
	}


}
