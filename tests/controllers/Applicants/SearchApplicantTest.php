<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class SearchApplicantTest extends TestCase
{
    /*
    *Trait to callback the BD
    */
    use DatabaseMigrations;
    
    /**************************************************
      *             SEARCH APPLICANTS
      **************************************************/
     /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa para 
     * buscar un solicitante por por el valor name
     */
    public function should_return_an_applicant_searched_to_name(){
        //ingresar resgitros de solicitantes
        $applicant = factory('App\Models\Applicant')->create();

        $this->seeInDatabase('applicants', $applicant->toArray());
        //comprobar codigo de respuesta
        $this->get(route('searchApplicant',['quest' => $applicant->name,'page'=>1,'limit'=>1]),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_OK);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data'=>[
                'total',
                'per_page', 
                'current_page',
                'last_page',
                'first_page_url',
                'last_page_url',
                'next_page_url',
                'prev_page_url',
                'path',
                'from',
                'to',
                'data',
            ],
            'code',
            'type'
        ]);

        
    }


     /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa para 
     * buscar un solicitante por por el valor surname
     */
    public function should_return_an_applicant_searched_to_surname(){
        //ingresar resgitros de solicitantes
        $applicant = factory('App\Models\Applicant')->create();

        $this->seeInDatabase('applicants', $applicant->toArray());
        //comprobar codigo de respuesta
        $this->get(route('searchApplicant',['quest' => $applicant->surname,'page'=>1,'limit'=>1]),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_OK);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data'=>[
                'total',
                'per_page', 
                'current_page',
                'last_page',
                'first_page_url',
                'last_page_url',
                'next_page_url',
                'prev_page_url',
                'path',
                'from',
                'to',
                'data',
            ],
            'code',
            'type'
        ]);

        
    }

      /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa para 
     * buscar un solicitante por por el valor dni
     */
    public function should_return_an_employe_searched_to_dni(){
        //ingresar resgitros de solicitantes
        $applicant = factory('App\Models\Applicant')->create();

        $this->seeInDatabase('applicants', $applicant->toArray());
        //comprobar codigo de respuesta
        $this->get(route('searchApplicant',['quest' => $applicant->dni,'page'=>1,'limit'=>1]),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_OK);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data'=>[
                'total',
                'per_page', 
                'current_page',
                'last_page',
                'first_page_url',
                'last_page_url',
                'next_page_url',
                'prev_page_url',
                'path',
                'from',
                'to',
                'data',
            ],
            'code',
            'type'
        ]);

        
    }


    /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa para 
     * validar que si no enviamos el campo de consulta
     * seguirá retornando  todos los solicitantes con paginación
     */
    public function should_not_return_an_employe_searched_whithout_field_quest(){
        //ingresar resgitros de solicitantes
        $applicant = factory('App\Models\Applicant')->create();

        $this->seeInDatabase('applicants', $applicant->toArray());
        //comprobar codigo de respuesta
        $this->get(route('searchApplicant',['page'=>1,'limit'=>1]),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_OK);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data'=>[
                'total',
                'per_page', 
                'current_page',
                'last_page',
                'first_page_url',
                'last_page_url',
                'next_page_url',
                'prev_page_url',
                'path',
                'from',
                'to',
                'data',
            ],
            'code',
            'type'
        ]);

    }

        

    /*****************************************************
     *                   FIELD LIMIT                     *
     *****************************************************/

      /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa para validar la buqueda
     * de un solicitante por por el valor del campo limit
     */
    public function invalid_search_of_applicants_with_value_smaller_than_1_in_field_limit(){
        //ingresar resgitros de solicitantes
        $applicant = factory('App\Models\Applicant')->create();

        $this->seeInDatabase('applicants', $applicant->toArray());
        //comprobar codigo de respuesta
        $this->get(route('searchApplicant',['quest' => $applicant->dni,'page'=>1,'limit'=>0]),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'limit'
            ],
            'code',
            'type'
        ]);
    }

     /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la búqueda invalida de
    * solicitantes cuando se envia un limit con un dato de otro tipo que no es numérico
    */
    public function invalid_search_of_applicants_with_incorrect_type_limit(){
        //ingresar resgitros de solicitantes
        $applicant = factory('App\Models\Applicant')->create();

        $this->seeInDatabase('applicants', $applicant->toArray());
        //comprobar codigo de respuesta
        $this->get(route('searchApplicant',['quest' => $applicant->dni,'page'=>1,'limit'=>"Limit"]),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'limit'
            ],
            'code',
            'type'
        ]);
    }

    /*****************************************************
     *                   FIELD PAGE                     *
     *****************************************************/

      /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa validar la buqueda
     * de un solicitante por por el valor del campo page
     */
    public function invalid_search_of_applicants_with_value_smaller_than_1_in_field_page(){
        //ingresar resgitros de solicitantes
        $applicant = factory('App\Models\Applicant')->create();

        $this->seeInDatabase('applicants', $applicant->toArray());
        //comprobar codigo de respuesta
        $this->get(route('searchApplicant',['quest' => $applicant->dni,'page'=>-10,'limit'=>1]),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'page'
            ],
            'code',
            'type'
        ]);
    }

     /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la búqueda invalida de
    * solicitantes cuando se envia un page con un dato de otro tipo que no es numérico
    */
    public function invalid_search_of_applicants_with_incorrect_type_page(){
        //ingresar resgitros de solicitantes
        $applicant = factory('App\Models\Applicant')->create();

        $this->seeInDatabase('applicants', $applicant->toArray());
        //comprobar codigo de respuesta
        $this->get(route('searchApplicant',['quest' => $applicant->dni,'page'=>"page",'limit'=>1]),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'page'
            ],
            'code',
            'type'
        ]);
    }


     
 

     
}  