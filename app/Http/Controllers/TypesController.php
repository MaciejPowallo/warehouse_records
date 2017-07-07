<?php
namespace App\Http\Controllers;
use Request;
use App\Type;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateTypeRequest;
use Session;

class TypesController extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {
        $search_name = Request::get('search_name');
        $search_description = Request::get('search_description');

        if($search_name != ''){
            $counter = Type::where('name_type','like','%'.$search_name.'%')->count();
            $types = Type::where('name_type','like','%'.$search_name.'%')->orderBy('name_type')->paginate($counter);}

        elseif($search_description != ''){
            $counter = Type::where('name_type','like','%'.$search_name.'%')->count();
            $types = Type::where('description','like','%'.$search_description.'%')->orderBy('name_type')->paginate($counter);}

        else{
            $counter = Type::count();
            $types = Type::latest()->paginate(30);}

    // Zwrócenie wyniku
        return view('types.index')->with('types', $types)->with('counter', $counter);
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
	 	$type =	Type::findOrFail($id);
    	return view('types.show')->with('type', $type);
    }

//Tworzenie nowego elemetu
    public function create()
    {
    	return view('types.create');
    }

//Zapisanie dodanego elementu
    public function store(CreateTypeRequest $request)
    {
        $this->validate($request, [
            'name_type'         => 'required|max:50|min:2|unique:types,name_type|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-_\. ]{2,})$/',
            'description'       => 'max:250|min:5|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\(\)\+\-.,:;=?!@&#%\[\]\/\^\$" ]{5,})$/',
         ]);

    	Type::create($request->all());

        //Informacje z sesji
        Session::flash('mes_type_add', 'Typ produktu został poprawnie dodany');

        //przekierowanie po udanej operacji
    	return redirect('types');
    }

// Edycja elementu
    public function edit($id)
    {
	 	$type =	Type::findOrFail($id);
    	return view('types.edit')->with('type', $type);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateTypeRequest $request)
    {
        $type = Type::findOrFail($id);

        $this->validate($request, [
            'name_type'         => 'required|max:50|min:2|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-_\. ]{2,})$/',
            'name_type'         =>  Rule::unique('types')->ignore($type->id),
            'description'       => 'max:250|min:5|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\(\)\+\-.,:;=?!@&#%\[\]\/\^\$" ]{5,})$/',
         ]);

    	$type -> update($request->all());

        //Informacje z sesji
        Session::flash('mes_type_update', 'Zmiany został poprawie zapisane'); 

        //przekierowanie po udanej operacji
      	return view('types.show')->with('type', $type);
    }
}
