<?php

namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;
//use Illuminate\Http\Request;

class ValidationTest extends TestCase
{
//    CHECK VALIDATION

    /**
     * A test to attempt creating a properly formated article.
     *
     * @return void
     */
    public function testCreateArticle()
    {
        //When user submits post request to create article endpoint

        //First of all, checking that rules are working fine:
        $this->post('/store?statusRéservation=true&numéroRef=123456&nom=Test Nom&condition=bonne&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
        $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
        $response->assertStatus(200);
    }


    /**
     * A test Checking 'statusRéservation' rule 'required'.
     *
     * @return void
     */
    public function testStatusRéservationRequired()
    {
        //When user submits post request to create article endpoint

           //Checking 'statusRéservation' rule 'required':
           $this->post('/store?statusRéservation=&numéroRef=123456&nom=Test Nom&condition=bonne&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'statusRéservation' rule 'regex'.
     *
     * @return void
     */
    public function testStatusRéservationRegex()
    {
        //When user submits post request to create article endpoint

           //Checking 'statusRéservation' rule 'required':
           $this->post('/store?statusRéservation=not true&numéroRef=123456&nom=Test Nom&condition=bonne&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'numéroRef' rule 'required'.
     *
     * @return void
     */
    public function testNuméroRefRequired()
    {
        //When user submits post request to create article endpoint

           //Checking 'numéroRef' rule 'required':
           $this->post('/store?statusRéservation=1&numéroRef=&nom=Test Nom&condition=bonne&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'numéroRef' rule 'regex'  with one letter.
     *
     * @return void
     */
    public function testNuméroRefRegexAlpha()
    {
        //When user submits post request to create article endpoint

           //Checking 'numéroRef' rule 'regex' with one letter:
           $this->post('/store?statusRéservation=1&numéroRef=A23456&nom=Test Nom&condition=bonne&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'numéroRef' rule 'regex' with 5 digits.
     *
     * @return void
     */
    public function testNuméroRefRegexLessNumber()
    {
        //When user submits post request to create article endpoint

           //Checking 'numéroRef' rule 'regex' with 5 digits:
           $this->post('/store?statusRéservation=1&numéroRef=12345&nom=Test Nom&condition=bonne&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'numéroRef' rule 'regex' with 7 digits.
     *
     * @return void
     */
    public function testNuméroRefRegexMoreNumber()
    {
        //When user submits post request to create article endpoint

           //Checking 'numéroRef' rule 'regex' with 7 digits:
           $this->post('/store?statusRéservation=1&numéroRef=1234567&nom=Test Nom&condition=bonne&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'nom' Working.
     *
     * @return void
     */
    public function testNomWorking()
    {
        //When user submits post request to create article endpoint

           //Checking 'nom' working:
           $this->post('/store?statusRéservation=false&numéroRef=123456&nom=Teste Tiret-Guillemet\'simple&condition=bonne&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(200);
    }

    /**
     * A test Checking 'nom' rule 'required'.
     *
     * @return void
     */
    public function testNomRequired()
    {
        //When user submits post request to create article endpoint

           //Checking 'nom' rule 'required':
           $this->post('/store?statusRéservation=0&numéroRef=123456&nom=&condition=bonne&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'nom' rule 'regex' with a digit.
     *
     * @return void
     */
    public function testNomRegexDigit()
    {
        //When user submits post request to create article endpoint

           //Checking 'nom' rule 'regex' with a digit:
           $this->post('/store?statusRéservation=true&numéroRef=123456&nom=Test4 Nom&condition=bonne&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'nom' rule 'regex' with a special character.
     *
     * @return void
     */
    public function testNomRegexSpecialChar()
    {
        //When user submits post request to create article endpoint

           //Checking 'nom' rule 'regex' with a special character:
           $this->post('/store?statusRéservation=true&numéroRef=123456&nom=Test, Nom&condition=bonne&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }


    /**
     * A test Checking 'condition' Working with 2 characters.
     *
     * @return void
     */
    public function testConditionWorkingMin()
    {
        //When user submits post request to create article endpoint

           //Checking 'condition' working  with 2 characters:
           $this->post('/store?statusRéservation=false&numéroRef=123456&nom=Teste Tiret-Guillemet\'simple&condition=OK&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(200);
    }

        /**
     * A test Checking 'condition' Working with 20 characters.
     *
     * @return void
     */
    public function testConditionWorkingMax()
    {
        //When user submits post request to create article endpoint

           //Checking 'condition' working  with 20 characters:
           $this->post('/store?statusRéservation=false&numéroRef=123456&nom=Teste Tiret-Guillemet\'simple&condition=OK? Yes exactly 20 c&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(200);
    }

    /**
     * A test Checking 'condition' rule 'required'.
     *
     * @return void
     */
    public function testConditionRequired()
    {
        //When user submits post request to create article endpoint

           //Checking 'condition' rule 'required':
           $this->post('/store?statusRéservation=0&numéroRef=123456&nom==Teste Tiret-Guillemet\'simple&condition=&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'condition' rule 'regex' with less than 2 characters.
     *
     * @return void
     */
    public function testConditionRegexLess()
    {
        //When user submits post request to create article endpoint

           //Checking 'condition' rule 'regex' with less than 2 characters:
           $this->post('/store?statusRéservation=true&numéroRef=123456&nom=Test Nom&condition=b&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'condition' rule 'regex' with more than 20 characters.
     *
     * @return void
     */
    public function testConditionRegexMore()
    {
        //When user submits post request to create article endpoint

           //Checking 'condition' rule 'regex' with more than 20 characters:
           $this->post('/store?statusRéservation=true&numéroRef=123456&nom=Test Nom&condition=OK? Yes exactly 20 characters&lieuPièce=La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'lieuPièce' Working.
     *
     * @return void
     */
    public function testLieuPièceWorking()
    {
        //When user submits post request to create article endpoint

           //Checking 'lieuPièce' working:
           $this->post('/store?statusRéservation=false&numéroRef=123456&nom=Teste Tiret-Guillemet\'simple&condition=bonne&lieuPièce=Teste Tiret-Guillemet\'simple&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(200);
    }

    /**
     * A test Checking 'lieuPièce' rule 'required'.
     *
     * @return void
     */
    public function testLieuPièceRequired()
    {
        //When user submits post request to create article endpoint

           //Checking 'lieuPièce' rule 'required':
           $this->post('/store?statusRéservation=0&numéroRef=123456&nom=Teste Tiret-Guillemet\'simple&condition=bonne&lieuPièce=&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'lieuPièce' rule 'regex' with a digit.
     *
     * @return void
     */
    public function testLieuPièceRegexDigit()
    {
        //When user submits post request to create article endpoint

           //Checking 'lieuPièce' rule 'regex' with a digit:
           $this->post('/store?statusRéservation=true&numéroRef=123456&nom=Test Nom&condition=bonne&lieuPièce=1La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'lieuPièce' rule 'regex' with a special character.
     *
     * @return void
     */
    public function testLieuPièceRegexSpecialChar()
    {
        //When user submits post request to create article endpoint

           //Checking 'lieuPièce' rule 'regex' with a special character:
           $this->post('/store?statusRéservation=true&numéroRef=123456&nom=Test Nom&condition=bonne&lieuPièce=!La Chapelle d\'Albray&lieuService=Elbeuf-Sur-Seine');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'lieuService' Working.
     *
     * @return void
     */
    public function testLieuServiceWorking()
    {
        //When user submits post request to create article endpoint

           //Checking 'lieuService' working:
           $this->post('/store?statusRéservation=false&numéroRef=123456&nom=Teste Tiret-Guillemet\'simple&condition=bonne&lieuPièce=Teste Tiret-Guillemet\'simple&lieuService=Teste Tiret-Guillemet\'simple');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(200);
    }

    /**
     * A test Checking 'lieuService' rule 'required'.
     *
     * @return void
     */
    public function testLieuServiceRequired()
    {
        //When user submits post request to create article endpoint

           //Checking 'lieuService' rule 'required':
           $this->post('/store?statusRéservation=0&numéroRef=123456&nom=Teste Tiret-Guillemet\'simple&condition=bonne&lieuPièce=Teste Tiret-Guillemet\'simple&lieuService=');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'lieuService' rule 'regex' with a digit.
     *
     * @return void
     */
    public function testLieuServiceRegexDigit()
    {
        //When user submits post request to create article endpoint

           //Checking 'lieuService' rule 'regex' with a digit:
           $this->post('/store?statusRéservation=true&numéroRef=123456&nom=Test Nom&condition=bonne&lieuPièce=La Chapelle d\'Albray&lieuService=1Teste Tiret-Guillemet\'simple');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }

    /**
     * A test Checking 'lieuService' rule 'regex' with a special character.
     *
     * @return void
     */
    public function testLieuServiceRegexSpecialChar()
    {
        //When user submits post request to create article endpoint

           //Checking 'lieuService' rule 'regex' with a special character:
           $this->post('/store?statusRéservation=true&numéroRef=123456&nom=Test Nom&condition=bonne&lieuPièce=La Chapelle d\'Albray&lieuService=!Teste Tiret-Guillemet\'simple');
           $response = $this->get('/show/' . \DB::getPdo()->lastInsertId());
           $response->assertStatus(404);
    }
}
