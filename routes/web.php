<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@index'
]);

Route::auth();

Route::get('/home', 'HomeController@index');


Route::get('about', [
    'as' => 'about',
    'uses' => 'AboutController@index'
]);

Route::get('docs/{version?}/{doc?}', [
    'as' => 'docs.show',
    'uses' => 'DocsController@showDocs'
]);

Route::get('api/{version?}', [
    'as' => 'api.redirect',
    'uses' => function($version = 'kr'){
        return Redirect::to('https://laravel.com/api/'.$version);
    }
]);

//    Route::get('qna',[
//        'as' => 'qna.index',
//        'uses' => 'QnAController@index'
//    ]);

Route::get('news', [
    'as' => 'qna.index',
    'uses' => 'NewsController@index'
]);

/*
Route::group(['prefix' => 'auth', 'as' => 'social.'], function () {
    // Other route definitions...

    Route::get('{provider}', [
        'as'   => 'login',
        'uses' => 'Auth\AuthController@redirectToProvider'
    ]);
    Route::get('{provider}/callback', [
        'as'   => 'github.callback',
        'uses' => 'Auth\AuthController@handleProviderCallback'
    ]);
});
*/

Route::group(
    ['prefix' => 'qna'],
    function(){
        Route::get(
            '/',
            [
                'as' => 'qna.index',
                'uses' => 'QnAController@index'
            ]
        );
        Route::post(
            '/',
            [
                'as' => 'qna.store',
                'uses' => 'QnAController@store'
            ]
        );
        Route::get(
            '{id}',
            [
                'as' => 'qna.show',
                'uses' => 'QnAController@show'
            ]
        );
        Route::get(
            '{id}/edit',
            [
                'as' => 'qna.edit',
                'uses' => 'QnAController@show'
            ]
        );

    }
);

Route::group(
//    ['prefix' => 'forum', 'namespace' => '\Socieboy\Forum\Controllers', 'middleware' => 'web'],
    ['prefix' => 'forum'],
    function () {
        /**
         * Route GET for the main page
         */
        Route::get(
            '/',
            [
                'as' => 'forum',
                'uses' => 'ForumController@index'
            ]
        );

        /**
         * Route GET to filter conversations by topic
         */
        Route::get(
            '/topic/{topic}',
            [
                'as' => 'forum.topic',
                'uses' => 'ForumController@topic'
            ]
        );

        /**
         * Route POST to search or filter conversations
         */
        Route::post(
            '/search',
            [
                'as' => 'forum.search',
                'uses' => 'ForumController@search'
            ]
        );

        /**
         * Route POST to store a new conversation
         */
        Route::post(
            '/conversation',
            [
                'as' => 'forum.conversation.store',
                'uses' => 'ConversationController@store'
            ]
        );

        /**
         * Route GET to show a conversation
         */
        Route::get(
            '/conversation/{slug}',
            [
                'as' => 'forum.conversation.show',
                'uses' => 'ConversationController@show'
            ]
        );

        /**
         * Route GET to edit a conversation
         */
        Route::get('/conversation/{slug}/edit', [
            'as' => 'forum.conversation.edit',
            'uses' => 'ConversationController@edit'
        ]);

        /**
         * Route POST to edit a conversation
         */
        Route::post('/conversation/{slug}/edit', [
            'as' => 'forum.conversation.edit',
            'uses' => 'ConversationController@update'
        ]);

        /**
         * Route POST to store a new reply
         */
        Route::post(
            '/conversation/{slug}/reply',
            [
                'as' => 'forum.conversation.reply.store',
                'uses' => 'RepliesController@store'
            ]
        );

        /**
         * Route POST to do like a reply
         */
        Route::post(
            '/conversation/{slug}/reply/like',
            [
                'as' => 'forum.conversation.reply.like',
                'uses' => 'LikesController@like'
            ]
        );

        /**
         * Route POST to do unlike a reply
         */
        Route::post(
            '/conversation/{slug}/reply/unlike',
            [
                'as' => 'forum.conversation.reply.unlike',
                'uses' => 'LikesController@unlike'
            ]
        );

        /**
         * Route POST to check correct answer
         */
        Route::post(
            '/conversation/{slug}/reply/{conversation_user_id}/correct-answer',
            [
                'as' => 'forum.conversation.reply.correct-answer',
                'uses' => 'RepliesController@correctAnswer'
            ]
        );

        /**
         * Route GET to edit a reply
         */
        Route::get('/conversation/{slug}/reply/{reply_id}/edit', [
            'as' => 'forum.conversation.reply.edit',
            'uses' => 'RepliesController@edit'
        ]);

        /**
         * Route put to edit a reply
         */
        Route::put('/conversation/{slug}/reply/{reply_id}/edit', [
            'as' => 'forum.conversation.reply.edit',
            'uses' => 'RepliesController@update'
        ]);

        /**
         * Route POST to destroy a reply
         */
        Route::delete('/conversation/{slug}/reply/{reply_id}/destroy', [
            'as' => 'forum.conversation.reply.destroy',
            'uses' => 'RepliesController@destroy'
        ]);


        /**
         * Route to profile.
         */
        Route::post(
            '/{id}/profile',
            [
                'as' => 'forum.user.profile',
                'uses' => 'ProfileController@show'
            ]
        );
    }
);
