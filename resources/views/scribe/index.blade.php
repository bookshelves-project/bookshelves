<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Bookshelves API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('vendor/scribe/css/theme-default.style.css') }}" media="screen">
    <link rel="stylesheet" href="{{ asset('vendor/scribe/css/theme-default.print.css') }}" media="print">
    <script src="{{ asset('vendor/scribe/js/theme-default-3.6.0.js') }}"></script>

    <link rel="stylesheet" href="//unpkg.com/@highlightjs/cdn-assets@10.7.2/styles/obsidian.min.css">
    <script src="//unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>
    <script>
        hljs.highlightAll();
    </script>

    <script src="//cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>
    <script>
        var baseUrl = "http://localhost:8000";
    </script>
    <script src="{{ asset('vendor/scribe/js/tryitout-3.6.0.js') }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">
    <a href="#" id="nav-button">
        <span>
            MENU
            <img src="{{ asset('vendor/scribe/images/navbar.png') }}" alt="navbar-image" />
        </span>
    </a>
    <div class="tocify-wrapper">
        <div class="lang-selector">
            <a href="#" data-language-name="bash">bash</a>
            <a href="#" data-language-name="javascript">javascript</a>
        </div>
        <div class="search">
            <input type="text" class="search" id="input-search" placeholder="Search">
        </div>
        <ul class="search-results"></ul>

        <ul id="toc">
        </ul>

        <ul class="toc-footer" id="toc-footer">
            <li><a href="{{ route('scribe.postman') }}">View Postman collection</a></li>
            <li><a href="{{ route('scribe.openapi') }}">View OpenAPI spec</a></li>
            <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
        </ul>
        <ul class="toc-footer" id="last-updated">
            <li>Last updated: July 14 2021</li>
        </ul>
    </div>
    <div class="page-wrapper">
        <div class="dark-box"></div>
        <div class="content">
            <h1>Introduction</h1>
            <p>The API documentation for Bookshelves to use endpoints with another app.</p>
            <p>This documentation aims to provide all the information you need to work with our API.</p>
            <aside>As you scroll, you'll see code examples for working with the API in different programming languages
                in the dark area to the right (or as part of the content on mobile).
                You can switch the language used with the tabs at the top right (or from the nav menu at the top left on
                mobile).</aside>
            <blockquote>
                <p>Base URL</p>
            </blockquote>
            <pre><code class="language-yaml">http://localhost:8000</code></pre>

            <h1>Authenticating requests</h1>
            <p>This API is not authenticated.</p>

            <h1 id="author">Author</h1>

            <p>Endpoint to get Authors data.</p>

            <h2 id="author-GETapi-authors">Authors list</h2>

            <p>
            </p>

            <p>You can get all authors with alphabetic order on lastname with pagination.</p>

            <span id="example-requests-GETapi-authors">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/authors?per-page=5" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/authors"
);

const params = {
    "per-page": "5",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-authors">
                <blockquote>
                    <p>Example response (200):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4992
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;name&quot;: &quot;Douglas Adams&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;adams-douglas&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/adams-douglas&quot;
            },
            &quot;lastname&quot;: &quot;Adams&quot;,
            &quot;firstname&quot;: &quot;Douglas&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1207\/conversions\/adams-douglas-thumbnail.webp&quot;,
                &quot;og&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1207\/conversions\/adams-douglas-og.jpg&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1207\/conversions\/adams-douglas-simple.jpg&quot;,
                &quot;color&quot;: &quot;#7b654f&quot;
            },
            &quot;count&quot;: 5
        },
        {
            &quot;name&quot;: &quot;Ilona Andrews&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;andrews-ilona&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/andrews-ilona&quot;
            },
            &quot;lastname&quot;: &quot;Andrews&quot;,
            &quot;firstname&quot;: &quot;Ilona&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1208\/conversions\/andrews-ilona-thumbnail.webp&quot;,
                &quot;og&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1208\/conversions\/andrews-ilona-og.jpg&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1208\/conversions\/andrews-ilona-simple.jpg&quot;,
                &quot;color&quot;: &quot;#474134&quot;
            },
            &quot;count&quot;: 1
        },
        {
            &quot;name&quot;: &quot;Georges-Jean Arnaud&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;arnaud-georges-jean&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/arnaud-georges-jean&quot;
            },
            &quot;lastname&quot;: &quot;Arnaud&quot;,
            &quot;firstname&quot;: &quot;Georges-Jean&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1209\/conversions\/arnaud-georges-jean-thumbnail.webp&quot;,
                &quot;og&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1209\/conversions\/arnaud-georges-jean-og.jpg&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1209\/conversions\/arnaud-georges-jean-simple.jpg&quot;,
                &quot;color&quot;: &quot;#635947&quot;
            },
            &quot;count&quot;: 60
        },
        {
            &quot;name&quot;: &quot;Isaac Asimov&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;asimov-isaac&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/asimov-isaac&quot;
            },
            &quot;lastname&quot;: &quot;Asimov&quot;,
            &quot;firstname&quot;: &quot;Isaac&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1210\/conversions\/asimov-isaac-thumbnail.webp&quot;,
                &quot;og&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1210\/conversions\/asimov-isaac-og.jpg&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1210\/conversions\/asimov-isaac-simple.jpg&quot;,
                &quot;color&quot;: &quot;#313131&quot;
            },
            &quot;count&quot;: 37
        },
        {
            &quot;name&quot;: &quot;Sophie Audouin-Mamikonian&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;audouin-mamikonian-sophie&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/audouin-mamikonian-sophie&quot;
            },
            &quot;lastname&quot;: &quot;Audouin-Mamikonian&quot;,
            &quot;firstname&quot;: &quot;Sophie&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1211\/conversions\/audouin-mamikonian-sophie-thumbnail.webp&quot;,
                &quot;og&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1211\/conversions\/audouin-mamikonian-sophie-og.jpg&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/authors\/1211\/conversions\/audouin-mamikonian-sophie-simple.jpg&quot;,
                &quot;color&quot;: &quot;#967d75&quot;
            },
            &quot;count&quot;: 13
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=1&quot;,
        &quot;last&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=12&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 12,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=2&quot;,
                &quot;label&quot;: &quot;2&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=3&quot;,
                &quot;label&quot;: &quot;3&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=4&quot;,
                &quot;label&quot;: &quot;4&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=5&quot;,
                &quot;label&quot;: &quot;5&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=6&quot;,
                &quot;label&quot;: &quot;6&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=7&quot;,
                &quot;label&quot;: &quot;7&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=8&quot;,
                &quot;label&quot;: &quot;8&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=9&quot;,
                &quot;label&quot;: &quot;9&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=10&quot;,
                &quot;label&quot;: &quot;10&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=11&quot;,
                &quot;label&quot;: &quot;11&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=12&quot;,
                &quot;label&quot;: &quot;12&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/authors?page=2&quot;,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http:\/\/localhost:8000\/api\/authors&quot;,
        &quot;per_page&quot;: 5,
        &quot;to&quot;: 5,
        &quot;total&quot;: 58
    }
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-authors" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-authors"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-authors"></code></pre>
            </span>
            <span id="execution-error-GETapi-authors" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-authors"></code></pre>
            </span>
            <form id="form-GETapi-authors" data-method="GET" data-path="api/authors" data-authed="0" data-hasfiles="0"
                data-isarraybody="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
                autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-authors', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-authors" onclick="tryItOut('GETapi-authors');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-authors" onclick="cancelTryOut('GETapi-authors');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-authors" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/authors</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                <p>
                    <b><code>per-page</code></b>&nbsp;&nbsp;<small>integer</small> <i>optional</i> &nbsp;
                    <input type="number" name="per-page" data-endpoint="GETapi-authors" data-component="query" hidden>
                    <br>
                <p>Entities per page, 32 by default.</p>
                </p>
                <p>
                    <b><code>page</code></b>&nbsp;&nbsp;<small>integer</small> <i>optional</i> &nbsp;
                    <input type="number" name="page" data-endpoint="GETapi-authors" data-component="query" hidden>
                    <br>
                <p>The page number, 1 by default.</p>
                </p>
            </form>

            <h2 id="author-GETapi-authors--id-">Author details</h2>

            <p>
            </p>

            <p>Details for one author, find by slug.</p>

            <span id="example-requests-GETapi-authors--id-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/authors/lovecraft-howard-phillips" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/authors/lovecraft-howard-phillips"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-authors--id-">
                <blockquote>
                    <p>Example response (404):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4991
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;failed&quot;: &quot;No result for this param.&quot;
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-authors--id-" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-authors--id-"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-authors--id-"></code></pre>
            </span>
            <span id="execution-error-GETapi-authors--id-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-authors--id-"></code></pre>
            </span>
            <form id="form-GETapi-authors--id-" data-method="GET" data-path="api/authors/{id}" data-authed="0"
                data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-authors--id-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-authors--id-" onclick="tryItOut('GETapi-authors--id-');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-authors--id-" onclick="cancelTryOut('GETapi-authors--id-');"
                        hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-authors--id-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/authors/{id}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>id</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="id" data-endpoint="GETapi-authors--id-" data-component="url" required
                        hidden>
                    <br>
                <p>The slug of author.</p>
                </p>
            </form>

            <h2 id="author-GETapi-authors-books--author-">GET api/authors/books/{author}</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-authors-books--author-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/authors/books/3" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/authors/books/3"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-authors-books--author-">
                <blockquote>
                    <p>Example response (404):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4990
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Author].&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
    &quot;line&quot;: 383,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
            &quot;line&quot;: 332,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/nunomaduro\/collision\/src\/Adapters\/Laravel\/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 130,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-authors-books--author-" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-authors-books--author-"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-authors-books--author-"></code></pre>
            </span>
            <span id="execution-error-GETapi-authors-books--author-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-authors-books--author-"></code></pre>
            </span>
            <form id="form-GETapi-authors-books--author-" data-method="GET" data-path="api/authors/books/{author}"
                data-authed="0" data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-authors-books--author-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-authors-books--author-"
                        onclick="tryItOut('GETapi-authors-books--author-');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-authors-books--author-"
                        onclick="cancelTryOut('GETapi-authors-books--author-');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-authors-books--author-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/authors/books/{author}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>author</code></b>&nbsp;&nbsp;<small>integer</small> &nbsp;
                    <input type="number" name="author" data-endpoint="GETapi-authors-books--author-"
                        data-component="url" required hidden>
                    <br>
                </p>
            </form>

            <h2 id="author-GETapi-authors-series--author-">GET api/authors/series/{author}</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-authors-series--author-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/authors/series/dolor" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/authors/series/dolor"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-authors-series--author-">
                <blockquote>
                    <p>Example response (404):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4989
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Author].&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
    &quot;line&quot;: 383,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
            &quot;line&quot;: 332,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/nunomaduro\/collision\/src\/Adapters\/Laravel\/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 130,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-authors-series--author-" hidden>
                <blockquote>Received response<span
                        id="execution-response-status-GETapi-authors-series--author-"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-authors-series--author-"></code></pre>
            </span>
            <span id="execution-error-GETapi-authors-series--author-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-authors-series--author-"></code></pre>
            </span>
            <form id="form-GETapi-authors-series--author-" data-method="GET" data-path="api/authors/series/{author}"
                data-authed="0" data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-authors-series--author-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-authors-series--author-"
                        onclick="tryItOut('GETapi-authors-series--author-');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-authors-series--author-"
                        onclick="cancelTryOut('GETapi-authors-series--author-');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-authors-series--author-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/authors/series/{author}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>author</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="author" data-endpoint="GETapi-authors-series--author-" data-component="url"
                        required hidden>
                    <br>
                </p>
            </form>

            <h1 id="book">Book</h1>



            <h2 id="book-GETapi-books">GET api/books</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-books">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/books" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/books"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-books">
                <blockquote>
                    <p>Example response (200):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4999
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;title&quot;: &quot;La p&acirc;le lumi&egrave;re des t&eacute;n&egrave;bres&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;la-pale-lumiere-des-tenebres-fr&quot;,
                &quot;author&quot;: &quot;lhomme-erik&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/lhomme-erik\/la-pale-lumiere-des-tenebres-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Erik L'Homme&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;lhomme-erik&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/lhomme-erik&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Premiere mission pour Jasper : trafic de drogue chez les vampires.Jasper vit a Paris, va au lycee et joue de la cornemuse dans un grou...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;2018-06-05 22:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/947\/conversions\/la-pale-lumiere-des-tenebres-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/947\/conversions\/la-pale-lumiere-des-tenebres-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#26366b&quot;
            },
            &quot;volume&quot;: 1,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;A comme Association&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;a-comme-association-fr&quot;,
                    &quot;author&quot;: &quot;bottero-pierre&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/bottero-pierre\/a-comme-association-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Les limites obscures de la magie&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-limites-obscures-de-la-magie-fr&quot;,
                &quot;author&quot;: &quot;bottero-pierre&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/bottero-pierre\/les-limites-obscures-de-la-magie-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Pierre Bottero&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;bottero-pierre&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/bottero-pierre&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Ombe, est lyceenne a Paris et adore la moto. Elle a aussi l'incroyable pouvoir d'etre incassable ou presque. C'est pourquoi L'Associat...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;2018-06-05 22:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/730\/conversions\/les-limites-obscures-de-la-magie-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/730\/conversions\/les-limites-obscures-de-la-magie-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#3e6a2f&quot;
            },
            &quot;volume&quot;: 2,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;A comme Association&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;a-comme-association-fr&quot;,
                    &quot;author&quot;: &quot;bottero-pierre&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/bottero-pierre\/a-comme-association-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;L'&eacute;toffe fragile du monde&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;letoffe-fragile-du-monde-fr&quot;,
                &quot;author&quot;: &quot;lhomme-erik&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/lhomme-erik\/letoffe-fragile-du-monde-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Erik L'Homme&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;lhomme-erik&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/lhomme-erik&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Persuade qu'Ombe est en danger, Jasper part a sa recherche avec son compagnon Erglug, un troll a l'humour decapant. Catapultes a...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;0101-01-01 00:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/948\/conversions\/letoffe-fragile-du-monde-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/948\/conversions\/letoffe-fragile-du-monde-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#8d562a&quot;
            },
            &quot;volume&quot;: 3,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;A comme Association&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;a-comme-association-fr&quot;,
                    &quot;author&quot;: &quot;bottero-pierre&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/bottero-pierre\/a-comme-association-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Le Subtil Parfum du Soufre&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;le-subtil-parfum-du-soufre-fr&quot;,
                &quot;author&quot;: &quot;bottero-pierre&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/bottero-pierre\/le-subtil-parfum-du-soufre-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Pierre Bottero&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;bottero-pierre&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/bottero-pierre&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Lors d'une mission particulierement eprouvante, Ombe sauve la vie d'un loup-garou. Elle ne l'aurait peut-etre pas secouru si ell...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;0101-01-01 00:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/731\/conversions\/le-subtil-parfum-du-soufre-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/731\/conversions\/le-subtil-parfum-du-soufre-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#8d2a28&quot;
            },
            &quot;volume&quot;: 4,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;A comme Association&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;a-comme-association-fr&quot;,
                    &quot;author&quot;: &quot;bottero-pierre&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/bottero-pierre\/a-comme-association-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;L&agrave; o&ugrave; les Mots n'Existent pas&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;la-ou-les-mots-nexistent-pas-fr&quot;,
                &quot;author&quot;: &quot;lhomme-erik&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/lhomme-erik\/la-ou-les-mots-nexistent-pas-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Erik L'Homme&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;lhomme-erik&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/lhomme-erik&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Reveil brutal pour Jasper. Etendu sur son lit d'hopital, il pense d'abord etre passe dans l'au-dela. Puis,les souvenirs lui r...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;0101-01-01 00:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/949\/conversions\/la-ou-les-mots-nexistent-pas-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/949\/conversions\/la-ou-les-mots-nexistent-pas-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#65326a&quot;
            },
            &quot;volume&quot;: 5,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;A comme Association&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;a-comme-association-fr&quot;,
                    &quot;author&quot;: &quot;bottero-pierre&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/bottero-pierre\/a-comme-association-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Ce qui Dort dans la Nuit&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;ce-qui-dort-dans-la-nuit-fr&quot;,
                &quot;author&quot;: &quot;lhomme-erik&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/lhomme-erik\/ce-qui-dort-dans-la-nuit-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Erik L'Homme&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;lhomme-erik&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/lhomme-erik&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Lorsque Jasper se decide enfin a revenir a l'Association, il trouve porte close. Entre de faux Agents qui traquent un sorcier joueur d...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;0101-01-01 00:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/950\/conversions\/ce-qui-dort-dans-la-nuit-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/950\/conversions\/ce-qui-dort-dans-la-nuit-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#1c5a64&quot;
            },
            &quot;volume&quot;: 6,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;A comme Association&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;a-comme-association-fr&quot;,
                    &quot;author&quot;: &quot;bottero-pierre&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/bottero-pierre\/a-comme-association-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Car nos C&oelig;urs Sont Hant&eacute;s&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;car-nos-coeurs-sont-hantes-fr&quot;,
                &quot;author&quot;: &quot;lhomme-erik&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/lhomme-erik\/car-nos-coeurs-sont-hantes-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Erik L'Homme&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;lhomme-erik&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/lhomme-erik&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Reveille en fanfare par Fafnir, son sortilege-espion, Jasper s'apprete a partir sur les traces du dangereux chamane. Lorsque Jean-Lu...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;0101-01-01 00:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/951\/conversions\/car-nos-coeurs-sont-hantes-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/951\/conversions\/car-nos-coeurs-sont-hantes-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#531c22&quot;
            },
            &quot;volume&quot;: 7,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;A comme Association&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;a-comme-association-fr&quot;,
                    &quot;author&quot;: &quot;bottero-pierre&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/bottero-pierre\/a-comme-association-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Le regard br&ucirc;lant des &eacute;toiles&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;le-regard-brulant-des-etoiles-fr&quot;,
                &quot;author&quot;: &quot;lhomme-erik&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/lhomme-erik\/le-regard-brulant-des-etoiles-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Erik L'Homme&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;lhomme-erik&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/lhomme-erik&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;2013-04-14 22:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/952\/conversions\/le-regard-brulant-des-etoiles-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/952\/conversions\/le-regard-brulant-des-etoiles-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#526880&quot;
            },
            &quot;volume&quot;: 8,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;A comme Association&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;a-comme-association-fr&quot;,
                    &quot;author&quot;: &quot;bottero-pierre&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/bottero-pierre\/a-comme-association-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;A Study in Scarlet&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;a-study-in-scarlet-en&quot;,
                &quot;author&quot;: &quot;doyle-arthur-conan&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/doyle-arthur-conan\/a-study-in-scarlet-en&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Arthur Conan Doyle&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;doyle-arthur-conan&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/doyle-arthur-conan&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;A Study in Scarlet is a detective mystery novel written by Sir Arthur Conan Doyle, which was first published in 1887. It is the first sto...&quot;,
            &quot;language&quot;: &quot;en&quot;,
            &quot;publishDate&quot;: &quot;1887-01-14 23:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/799\/conversions\/a-study-in-scarlet-en-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/799\/conversions\/a-study-in-scarlet-en-simple.jpg&quot;,
                &quot;color&quot;: &quot;#c4b8ab&quot;
            },
            &quot;volume&quot;: 0,
            &quot;serie&quot;: null
        },
        {
            &quot;title&quot;: &quot;L'Affaire Charles Dexter Ward&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;laffaire-charles-dexter-ward-fr&quot;,
                &quot;author&quot;: &quot;lovecraft-howard-phillips&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/lovecraft-howard-phillips\/laffaire-charles-dexter-ward-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Howard Phillips Lovecraft&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;lovecraft-howard-phillips&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/lovecraft-howard-phillips&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Providence, Etats-Unis, 1918. Charles Dexter Ward est un jeune homme passionne d'archeologie, d'histoire, et de genealogie. C'est pa...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;1928-06-14 23:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/975\/conversions\/laffaire-charles-dexter-ward-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/975\/conversions\/laffaire-charles-dexter-ward-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#f0d9b6&quot;
            },
            &quot;volume&quot;: 0,
            &quot;serie&quot;: null
        },
        {
            &quot;title&quot;: &quot;Les aigles de Vishan Lour&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-aigles-de-vishan-lour-fr&quot;,
                &quot;author&quot;: &quot;bottero-pierre&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/bottero-pierre\/les-aigles-de-vishan-lour-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Pierre Bottero&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;bottero-pierre&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/bottero-pierre&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Plume est une Ombre, une jeune acrobate qui sillonne les rues d'AnOcour et vole pour survivre. Esteblan est un ecuyer de la confrer...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;2019-09-10 22:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/746\/conversions\/les-aigles-de-vishan-lour-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/746\/conversions\/les-aigles-de-vishan-lour-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#ac8f89&quot;
            },
            &quot;volume&quot;: 0,
            &quot;serie&quot;: null
        },
        {
            &quot;title&quot;: &quot;Air Froid&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;air-froid-fr&quot;,
                &quot;author&quot;: &quot;lovecraft-howard-phillips&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/lovecraft-howard-phillips\/air-froid-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Howard Phillips Lovecraft&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;lovecraft-howard-phillips&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/lovecraft-howard-phillips&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Cool Air, 1926 Un jeune homme frileux, recemment installe dans un appartement new-yorkais, fait la connaissance d'un vieil homme qui ap...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;1926-06-14 23:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/976\/conversions\/air-froid-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/976\/conversions\/air-froid-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#eee&quot;
            },
            &quot;volume&quot;: 0,
            &quot;serie&quot;: null
        },
        {
            &quot;title&quot;: &quot;American Gods&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;american-gods-fr&quot;,
                &quot;author&quot;: &quot;gaiman-neil&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/gaiman-neil\/american-gods-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Neil Gaiman&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;gaiman-neil&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/gaiman-neil&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Dans le vol qui l'emmene a l'enterrement de sa femme tant aimee, Ombre rencontre Voyageur, un intrigant personnage. Dieu antique, comm...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;2001-04-05 00:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/827\/conversions\/american-gods-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/827\/conversions\/american-gods-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#627e57&quot;
            },
            &quot;volume&quot;: 0,
            &quot;serie&quot;: null
        },
        {
            &quot;title&quot;: &quot;Les &Acirc;mes Crois&eacute;es&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-ames-croisees-fr&quot;,
                &quot;author&quot;: &quot;bottero-pierre&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/bottero-pierre\/les-ames-croisees-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Pierre Bottero&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;bottero-pierre&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/bottero-pierre&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Nawel est une jeune fille Perle pretentieuse et exigeante. Un jour, en se baladant dans la ville Cendre, elle bouscule une jeune Cendre...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;0101-01-01 00:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/744\/conversions\/les-ames-croisees-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/744\/conversions\/les-ames-croisees-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#a89d62&quot;
            },
            &quot;volume&quot;: 0,
            &quot;serie&quot;: null
        },
        {
            &quot;title&quot;: &quot;L'Amour, vous connaissez ?&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;lamour-vous-connaissez-fr&quot;,
                &quot;author&quot;: &quot;asimov-isaac&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/asimov-isaac\/lamour-vous-connaissez-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Isaac Asimov&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;asimov-isaac&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/asimov-isaac&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Revivez votre premiere rencontre avec l'etre aime, dans un train, grace a un etrange magicien... Alors qu'ailleurs deux savants ext...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;1969-01-02 11:23:54&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/647\/conversions\/lamour-vous-connaissez-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/647\/conversions\/lamour-vous-connaissez-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#5492b6&quot;
            },
            &quot;volume&quot;: 0,
            &quot;serie&quot;: null
        },
        {
            &quot;title&quot;: &quot;La Huiti&egrave;me couleur&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;la-huitieme-couleur-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/la-huitieme-couleur-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Dans une dimension lointaine et passablement farfelue, un monde se balade a dos de quatre elephants, euxmemes juches sur la carapa...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;2011-05-02 06:22:51&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1029\/conversions\/la-huitieme-couleur-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1029\/conversions\/la-huitieme-couleur-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#827e7e&quot;
            },
            &quot;volume&quot;: 1,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Le Huiti&egrave;me Sortil&egrave;ge&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;le-huitieme-sortilege-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/le-huitieme-sortilege-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Octogenaire, borgne, chauve et edente, Cohen le Barbare, le plus grand heros de tous les temps, reussira-t-il a tirer Deuxfleurs et...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;2011-05-06 04:38:14&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1040\/conversions\/le-huitieme-sortilege-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1040\/conversions\/le-huitieme-sortilege-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#855a3e&quot;
            },
            &quot;volume&quot;: 2,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;La huiti&egrave;me fille&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;la-huitieme-fille-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/la-huitieme-fille-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Sentant venir sa mort prochaine, le mage Tambour Billette organise la transmission de ses pouvoirs, de son bourdon, de son fonds de comme...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;1987-01-20 23:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1046\/conversions\/la-huitieme-fille-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1046\/conversions\/la-huitieme-fille-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#514431&quot;
            },
            &quot;volume&quot;: 3,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Mortimer&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;mortimer-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/mortimer-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Mortimer court a travers champs, agitant les bras et criant comme une truie qu'on egorge. Et non. Meme les oiseaux n'y croient pas.&amp;qu...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;1987-01-20 23:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1047\/conversions\/mortimer-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1047\/conversions\/mortimer-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#8d8d8e&quot;
            },
            &quot;volume&quot;: 4,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Sourcellerie&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;sourcellerie-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/sourcellerie-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;La magie, c'est de la bouillie pour les chats. Voici la sourcellerie, la puissance thaumaturgique de l'Aube des Temps ! Elle penetre le...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;1988-01-19 23:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1048\/conversions\/sourcellerie-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1048\/conversions\/sourcellerie-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#916a3c&quot;
            },
            &quot;volume&quot;: 5,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Trois soeurcieres&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;trois-soeurcieres-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/trois-soeurcieres-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;\&quot; Le vent hurlait. La foudre lardait le pays comme un assassin maladroit... La nuit etait aussi noire que l'intimite d'un chat. Un...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;1988-01-04 23:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1049\/conversions\/trois-soeurcieres-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1049\/conversions\/trois-soeurcieres-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#6d7c8f&quot;
            },
            &quot;volume&quot;: 6,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Pyramides&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;pyramides-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/pyramides-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Assis sur un bloc de pierre, le fantome du pharaon regardait les deux embaumeurs s'affairer sur sa depouille. Tout compte fait, on a du...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;1989-01-04 23:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1050\/conversions\/pyramides-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1050\/conversions\/pyramides-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#af7f5e&quot;
            },
            &quot;volume&quot;: 7,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Au guet !&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;au-guet-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/au-guet-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Une societe secrete d'encagoules complote pour renverser le seigneur Veterini, Patricien d'Ankh-Morpok, et lui substituer u...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;1989-01-04 23:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1051\/conversions\/au-guet-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1051\/conversions\/au-guet-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#635e43&quot;
            },
            &quot;volume&quot;: 8,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Eric&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;eric-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/eric-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Le &amp;quot;disque-monde&amp;quot; est plat, porte par quatre elephants debout sur le dos d'une tortue naviguant dans le cosmos. Tout le mond...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;2011-01-14 23:53:35&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1052\/conversions\/eric-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1052\/conversions\/eric-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#8b5e3d&quot;
            },
            &quot;volume&quot;: 9,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Les zinzins d'Olive-Oued&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-zinzins-dolive-oued-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/les-zinzins-dolive-oued-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Il ne se passe pas de jours sur le Disque-Monde sans que de terrifiantes decouvertes soient faites. Cette fois-ci, c'est Ankh Mo...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;1990-01-05 16:50:06&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1019\/conversions\/les-zinzins-dolive-oued-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1019\/conversions\/les-zinzins-dolive-oued-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#a9623f&quot;
            },
            &quot;volume&quot;: 10,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Le faucheur&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;le-faucheur-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/le-faucheur-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Fantomes vampires, zombis, banshees, croque-mitaines... Les morts vivants se multiplient. Car une catastrophe frappe l...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;2013-01-14 09:39:39&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1020\/conversions\/le-faucheur-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1020\/conversions\/le-faucheur-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#886440&quot;
            },
            &quot;volume&quot;: 11,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;M&eacute;comptes de f&eacute;es&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;mecomptes-de-fees-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/mecomptes-de-fees-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Une vieille sorciere a l'agonie legue sa baguette magique a Magrat Goussedail, a charge pour celle-ci d'aller a Genua, au b...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;1991-01-05 11:53:48&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1021\/conversions\/mecomptes-de-fees-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1021\/conversions\/mecomptes-de-fees-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#7d7b6d&quot;
            },
            &quot;volume&quot;: 12,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Les petits dieux&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-petits-dieux-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/les-petits-dieux-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Or il advint qu'Om, le grand dieu, prit la parole en ce temps-la, et s'adressa en ces termes a Frangin, l'Elu : \&quot; Psst !...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;1992-01-05 18:14:28&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1022\/conversions\/les-petits-dieux-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1022\/conversions\/les-petits-dieux-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#908b76&quot;
            },
            &quot;volume&quot;: 13,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Nobliaux et sorci&egrave;res&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;nobliaux-et-sorcieres-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/nobliaux-et-sorcieres-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Au cur des monts du Belier, en ecarquillant les yeux, on peut reperer le royaume de Lancre. En y regardant de plus pres, on reconnai...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;0101-01-01 00:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1023\/conversions\/nobliaux-et-sorcieres-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1023\/conversions\/nobliaux-et-sorcieres-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#7a7864&quot;
            },
            &quot;volume&quot;: 14,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Le guet des Orf&egrave;vres&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;le-guet-des-orfevres-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/le-guet-des-orfevres-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Ca chauffe dans les rues d'Ankh-Morpork. Entre les dragons qui explosent, les meurtres inexpliques et les feux d'artifice, ca sent le r...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;2003-08-11 00:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1024\/conversions\/le-guet-des-orfevres-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1024\/conversions\/le-guet-des-orfevres-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#6f3544&quot;
            },
            &quot;volume&quot;: 15,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Accros du roc&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;accros-du-roc-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/accros-du-roc-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Suzanne est une jeune etudiante discrete. Si discrete qu'elle devient tres souvent invisible. Un beau jour, la Mort aux Rats vient la...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;2011-06-28 22:00:00&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1025\/conversions\/accros-du-roc-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1025\/conversions\/accros-du-roc-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#776a4f&quot;
            },
            &quot;volume&quot;: 16,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        },
        {
            &quot;title&quot;: &quot;Les tribulations d'un mage en aurient&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-tribulations-dun-mage-en-aurient-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/books\/pratchett-terry\/les-tribulations-dun-mage-en-aurient-fr&quot;
            },
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;summary&quot;: &quot;Fige dans un immobilisme seculaire derriere sa Grande Muraille, voici l'impenetrable empire agateen d'Aurient. La tourmente va...&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;publishDate&quot;: &quot;2013-02-25 09:40:21&quot;,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1026\/conversions\/les-tribulations-dun-mage-en-aurient-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1026\/conversions\/les-tribulations-dun-mage-en-aurient-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#ab7139&quot;
            },
            &quot;volume&quot;: 17,
            &quot;serie&quot;: {
                &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
                &quot;meta&quot;: {
                    &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                    &quot;author&quot;: &quot;pratchett-terry&quot;,
                    &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
                }
            }
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=1&quot;,
        &quot;last&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=18&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 18,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=2&quot;,
                &quot;label&quot;: &quot;2&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=3&quot;,
                &quot;label&quot;: &quot;3&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=4&quot;,
                &quot;label&quot;: &quot;4&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=5&quot;,
                &quot;label&quot;: &quot;5&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=6&quot;,
                &quot;label&quot;: &quot;6&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=7&quot;,
                &quot;label&quot;: &quot;7&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=8&quot;,
                &quot;label&quot;: &quot;8&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=9&quot;,
                &quot;label&quot;: &quot;9&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=10&quot;,
                &quot;label&quot;: &quot;10&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;...&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=17&quot;,
                &quot;label&quot;: &quot;17&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=18&quot;,
                &quot;label&quot;: &quot;18&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/books?page=2&quot;,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http:\/\/localhost:8000\/api\/books&quot;,
        &quot;per_page&quot;: 32,
        &quot;to&quot;: 32,
        &quot;total&quot;: 563
    }
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-books" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-books"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-books"></code></pre>
            </span>
            <span id="execution-error-GETapi-books" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-books"></code></pre>
            </span>
            <form id="form-GETapi-books" data-method="GET" data-path="api/books" data-authed="0" data-hasfiles="0"
                data-isarraybody="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
                autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-books', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-books" onclick="tryItOut('GETapi-books');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-books" onclick="cancelTryOut('GETapi-books');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-books" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/books</code></b>
                </p>
            </form>

            <h2 id="book-GETapi-books--author---book-">GET api/books/{author}/{book}</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-books--author---book-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/books/20/eos" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/books/20/eos"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-books--author---book-">
                <blockquote>
                    <p>Example response (404):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4998
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Author].&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
    &quot;line&quot;: 383,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
            &quot;line&quot;: 332,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/nunomaduro\/collision\/src\/Adapters\/Laravel\/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 130,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-books--author---book-" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-books--author---book-"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-books--author---book-"></code></pre>
            </span>
            <span id="execution-error-GETapi-books--author---book-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-books--author---book-"></code></pre>
            </span>
            <form id="form-GETapi-books--author---book-" data-method="GET" data-path="api/books/{author}/{book}"
                data-authed="0" data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-books--author---book-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-books--author---book-"
                        onclick="tryItOut('GETapi-books--author---book-');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-books--author---book-"
                        onclick="cancelTryOut('GETapi-books--author---book-');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-books--author---book-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/books/{author}/{book}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>author</code></b>&nbsp;&nbsp;<small>integer</small> &nbsp;
                    <input type="number" name="author" data-endpoint="GETapi-books--author---book-" data-component="url"
                        required hidden>
                    <br>
                </p>
                <p>
                    <b><code>book</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="book" data-endpoint="GETapi-books--author---book-" data-component="url"
                        required hidden>
                    <br>
                </p>
            </form>

            <h2 id="book-GETapi-books-related--author---book-">GET api/books/related/{author}/{book}</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-books-related--author---book-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/books/related/laboriosam/expedita" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/books/related/laboriosam/expedita"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-books-related--author---book-">
                <blockquote>
                    <p>Example response (500):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4997
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;Attempt to read property \&quot;id\&quot; on null&quot;,
    &quot;exception&quot;: &quot;ErrorException&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/app\/Http\/Controllers\/Api\/BookController.php&quot;,
    &quot;line&quot;: 240,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/app\/Http\/Controllers\/Api\/BookController.php&quot;,
            &quot;line&quot;: 240,
            &quot;function&quot;: &quot;handleError&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Bootstrap\\HandleExceptions&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Builder.php&quot;,
            &quot;line&quot;: 1174,
            &quot;function&quot;: &quot;App\\Http\\Controllers\\Api\\{closure}&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\Api\\BookController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Concerns\/QueriesRelationships.php&quot;,
            &quot;line&quot;: 56,
            &quot;function&quot;: &quot;callScope&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Concerns\/QueriesRelationships.php&quot;,
            &quot;line&quot;: 147,
            &quot;function&quot;: &quot;has&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Support\/Traits\/ForwardsCalls.php&quot;,
            &quot;line&quot;: 23,
            &quot;function&quot;: &quot;whereHas&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Model.php&quot;,
            &quot;line&quot;: 2000,
            &quot;function&quot;: &quot;forwardCallTo&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Model.php&quot;,
            &quot;line&quot;: 2012,
            &quot;function&quot;: &quot;__call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/app\/Http\/Controllers\/Api\/BookController.php&quot;,
            &quot;line&quot;: 241,
            &quot;function&quot;: &quot;__callStatic&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;related&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\Api\\BookController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;callAction&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Controller&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php&quot;,
            &quot;line&quot;: 254,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\ControllerDispatcher&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php&quot;,
            &quot;line&quot;: 197,
            &quot;function&quot;: &quot;runController&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 695,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Routing\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-books-related--author---book-" hidden>
                <blockquote>Received response<span
                        id="execution-response-status-GETapi-books-related--author---book-"></span>:
                </blockquote>
                <pre
                    class="json"><code id="execution-response-content-GETapi-books-related--author---book-"></code></pre>
            </span>
            <span id="execution-error-GETapi-books-related--author---book-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-books-related--author---book-"></code></pre>
            </span>
            <form id="form-GETapi-books-related--author---book-" data-method="GET"
                data-path="api/books/related/{author}/{book}" data-authed="0" data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-books-related--author---book-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-books-related--author---book-"
                        onclick="tryItOut('GETapi-books-related--author---book-');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-books-related--author---book-"
                        onclick="cancelTryOut('GETapi-books-related--author---book-');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-books-related--author---book-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/books/related/{author}/{book}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>author</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="author" data-endpoint="GETapi-books-related--author---book-"
                        data-component="url" required hidden>
                    <br>
                </p>
                <p>
                    <b><code>book</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="book" data-endpoint="GETapi-books-related--author---book-"
                        data-component="url" required hidden>
                    <br>
                </p>
            </form>

            <h2 id="book-GETapi-books-latest">GET api/books/latest</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-books-latest">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/books/latest" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/books/latest"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-books-latest">
                <blockquote>
                    <p>Example response (200):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4979
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;troisi-licia&quot;,
                &quot;slug&quot;: &quot;lepee-des-rebelles-fr&quot;
            },
            &quot;title&quot;: &quot;L'&eacute;p&eacute;e des rebelles&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Licia Troisi&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;troisi-licia&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/troisi-licia&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;Les royaumes de Nashira&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 2,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1125\/conversions\/lepee-des-rebelles-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1125\/lepee-des-rebelles-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1125\/conversions\/lepee-des-rebelles-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#7b6d6d&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;troisi-licia&quot;,
                &quot;slug&quot;: &quot;le-reve-de-talitha-fr&quot;
            },
            &quot;title&quot;: &quot;Le r&ecirc;ve de Talitha&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Licia Troisi&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;troisi-licia&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/troisi-licia&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;Les royaumes de Nashira&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 1,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1124\/conversions\/le-reve-de-talitha-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1124\/le-reve-de-talitha-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1124\/conversions\/le-reve-de-talitha-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#6e4642&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;troisi-licia&quot;,
                &quot;slug&quot;: &quot;le-sacrifice-fr&quot;
            },
            &quot;title&quot;: &quot;Le Sacrifice&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Licia Troisi&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;troisi-licia&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/troisi-licia&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;Les royaumes de Nashira&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 3,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1126\/conversions\/le-sacrifice-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1126\/le-sacrifice-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1126\/conversions\/le-sacrifice-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#693f45&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;troisi-licia&quot;,
                &quot;slug&quot;: &quot;lultime-affrontement-fr&quot;
            },
            &quot;title&quot;: &quot;L'ultime affrontement&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Licia Troisi&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;troisi-licia&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/troisi-licia&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;La Fille Dragon&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 5,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1123\/conversions\/lultime-affrontement-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1123\/lultime-affrontement-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1123\/conversions\/lultime-affrontement-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#6c2915&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;troisi-licia&quot;,
                &quot;slug&quot;: &quot;les-jumeaux-de-kuma-fr&quot;
            },
            &quot;title&quot;: &quot;Les jumeaux de Kuma&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Licia Troisi&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;troisi-licia&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/troisi-licia&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;La Fille Dragon&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 4,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1122\/conversions\/les-jumeaux-de-kuma-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1122\/les-jumeaux-de-kuma-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1122\/conversions\/les-jumeaux-de-kuma-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#655a63&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;troisi-licia&quot;,
                &quot;slug&quot;: &quot;larbre-didhunn-fr&quot;
            },
            &quot;title&quot;: &quot;L'Arbre d'Idhunn&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Licia Troisi&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;troisi-licia&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/troisi-licia&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;La Fille Dragon&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 2,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1120\/conversions\/larbre-didhunn-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1120\/larbre-didhunn-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1120\/conversions\/larbre-didhunn-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#345952&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;troisi-licia&quot;,
                &quot;slug&quot;: &quot;lheritage-de-thuban-fr&quot;
            },
            &quot;title&quot;: &quot;L&rsquo;h&eacute;ritage de Thuban&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Licia Troisi&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;troisi-licia&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/troisi-licia&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;La Fille Dragon&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 1,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1119\/conversions\/lheritage-de-thuban-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1119\/lheritage-de-thuban-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1119\/conversions\/lheritage-de-thuban-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#5f523f&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;troisi-licia&quot;,
                &quot;slug&quot;: &quot;un-nouveau-regne-fr&quot;
            },
            &quot;title&quot;: &quot;Un nouveau R&egrave;gne&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Licia Troisi&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;troisi-licia&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/troisi-licia&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;Guerres du Monde &Eacute;merg&eacute;&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 3,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1118\/conversions\/un-nouveau-regne-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1118\/un-nouveau-regne-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1118\/conversions\/un-nouveau-regne-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#245a5b&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;troisi-licia&quot;,
                &quot;slug&quot;: &quot;les-deux-combattantes-fr&quot;
            },
            &quot;title&quot;: &quot;Les deux Combattantes&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Licia Troisi&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;troisi-licia&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/troisi-licia&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;Guerres du Monde &Eacute;merg&eacute;&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 2,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1117\/conversions\/les-deux-combattantes-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1117\/les-deux-combattantes-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1117\/conversions\/les-deux-combattantes-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#8e602e&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;troisi-licia&quot;,
                &quot;slug&quot;: &quot;ma-sablier-daldibah-fr&quot;
            },
            &quot;title&quot;: &quot;Ma Sablier d'Aldibah&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Licia Troisi&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;troisi-licia&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/troisi-licia&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;La Fille Dragon&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 3,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1121\/conversions\/ma-sablier-daldibah-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1121\/ma-sablier-daldibah-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1121\/conversions\/ma-sablier-daldibah-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#6e6741&quot;
            }
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-books-latest" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-books-latest"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-books-latest"></code></pre>
            </span>
            <span id="execution-error-GETapi-books-latest" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-books-latest"></code></pre>
            </span>
            <form id="form-GETapi-books-latest" data-method="GET" data-path="api/books/latest" data-authed="0"
                data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-books-latest', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-books-latest" onclick="tryItOut('GETapi-books-latest');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-books-latest" onclick="cancelTryOut('GETapi-books-latest');"
                        hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-books-latest" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/books/latest</code></b>
                </p>
            </form>

            <h2 id="book-GETapi-books-selection">GET api/books/selection</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-books-selection">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/books/selection" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/books/selection"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-books-selection">
                <blockquote>
                    <p>Example response (200):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4978
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;bottero-pierre&quot;,
                &quot;slug&quot;: &quot;le-subtil-parfum-du-soufre-fr&quot;
            },
            &quot;title&quot;: &quot;Le Subtil Parfum du Soufre&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Pierre Bottero&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;bottero-pierre&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/bottero-pierre&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;A comme Association&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 4,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/731\/conversions\/le-subtil-parfum-du-soufre-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/731\/le-subtil-parfum-du-soufre-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/731\/conversions\/le-subtil-parfum-du-soufre-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#8d2a28&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;slug&quot;: &quot;masquarade-fr&quot;
            },
            &quot;title&quot;: &quot;Masquarade&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;Les Annales du Disque-Monde&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 18,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1027\/conversions\/masquarade-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1027\/masquarade-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1027\/conversions\/masquarade-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#643c28&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;arnaud-georges-jean&quot;,
                &quot;slug&quot;: &quot;le-sanctuaire-des-glaces-fr&quot;
            },
            &quot;title&quot;: &quot;Le Sanctuaire des glaces&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Georges-Jean Arnaud&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;arnaud-georges-jean&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/arnaud-georges-jean&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;La Compagnie des glaces&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 2,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/590\/conversions\/le-sanctuaire-des-glaces-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/590\/le-sanctuaire-des-glaces-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/590\/conversions\/le-sanctuaire-des-glaces-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#96615a&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;arnaud-georges-jean&quot;,
                &quot;slug&quot;: &quot;la-compagnie-des-glaces-fr&quot;
            },
            &quot;title&quot;: &quot;La Compagnie des glaces&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Georges-Jean Arnaud&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;arnaud-georges-jean&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/arnaud-georges-jean&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;La Compagnie des glaces&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 1,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/580\/conversions\/la-compagnie-des-glaces-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/580\/la-compagnie-des-glaces-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/580\/conversions\/la-compagnie-des-glaces-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#303331&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;lewis-clive-staples&quot;,
                &quot;slug&quot;: &quot;prince-caspian-fr&quot;
            },
            &quot;title&quot;: &quot;Prince Caspian&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Clive Staples Lewis&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;lewis-clive-staples&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/lewis-clive-staples&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;Les Chroniques de Narnia&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 4,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/956\/conversions\/prince-caspian-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/956\/prince-caspian-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/956\/conversions\/prince-caspian-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#af8663&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;bottero-pierre&quot;,
                &quot;slug&quot;: &quot;ellana-la-prophetie-fr&quot;
            },
            &quot;title&quot;: &quot;Ellana - La proph&eacute;tie&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Pierre Bottero&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;bottero-pierre&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/bottero-pierre&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;Le Pacte des Marchombres&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 3,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/740\/conversions\/ellana-la-prophetie-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/740\/ellana-la-prophetie-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/740\/conversions\/ellana-la-prophetie-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#847c40&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;slug&quot;: &quot;le-dernier-heros-fr&quot;
            },
            &quot;title&quot;: &quot;Le dernier h&eacute;ros&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;Les Annales du Disque-Monde&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 23,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1033\/conversions\/le-dernier-heros-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1033\/le-dernier-heros-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1033\/conversions\/le-dernier-heros-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#7e6c78&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;robillard-anne&quot;,
                &quot;slug&quot;: &quot;represailles-fr&quot;
            },
            &quot;title&quot;: &quot;Represailles&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Anne Robillard&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;robillard-anne&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/robillard-anne&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;Les Chevaliers d'&Eacute;meraude&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 10,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1058\/conversions\/represailles-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1058\/represailles-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1058\/conversions\/represailles-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#604e39&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;colfer-eoin&quot;,
                &quot;slug&quot;: &quot;le-paradoxe-du-temps-fr&quot;
            },
            &quot;title&quot;: &quot;Le Paradoxe du Temps&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Eoin Colfer&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;colfer-eoin&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/colfer-eoin&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;Artemis Fowl&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 6,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/775\/conversions\/le-paradoxe-du-temps-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/775\/le-paradoxe-du-temps-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/775\/conversions\/le-paradoxe-du-temps-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#9e8543&quot;
            }
        },
        {
            &quot;meta&quot;: {
                &quot;entity&quot;: &quot;book&quot;,
                &quot;author&quot;: &quot;troisi-licia&quot;,
                &quot;slug&quot;: &quot;le-sacrifice-fr&quot;
            },
            &quot;title&quot;: &quot;Le Sacrifice&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Licia Troisi&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;troisi-licia&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/troisi-licia&quot;
                    }
                }
            ],
            &quot;serie&quot;: &quot;Les royaumes de Nashira&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;volume&quot;: 3,
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1126\/conversions\/le-sacrifice-fr-thumbnail.webp&quot;,
                &quot;original&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1126\/le-sacrifice-fr.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/books\/1126\/conversions\/le-sacrifice-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#693f45&quot;
            }
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-books-selection" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-books-selection"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-books-selection"></code></pre>
            </span>
            <span id="execution-error-GETapi-books-selection" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-books-selection"></code></pre>
            </span>
            <form id="form-GETapi-books-selection" data-method="GET" data-path="api/books/selection" data-authed="0"
                data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-books-selection', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-books-selection" onclick="tryItOut('GETapi-books-selection');">Try it out
                        ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-books-selection" onclick="cancelTryOut('GETapi-books-selection');"
                        hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-books-selection" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/books/selection</code></b>
                </p>
            </form>

            <h1 id="download">Download</h1>



            <h2 id="download-GETapi-download-book--author---book-">GET api/download/book/{author}/{book}</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-download-book--author---book-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/download/book/10/neque" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/download/book/10/neque"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-download-book--author---book-">
                <blockquote>
                    <p>Example response (404):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4982
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Book].&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
    &quot;line&quot;: 383,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
            &quot;line&quot;: 332,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/nunomaduro\/collision\/src\/Adapters\/Laravel\/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 130,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-download-book--author---book-" hidden>
                <blockquote>Received response<span
                        id="execution-response-status-GETapi-download-book--author---book-"></span>:
                </blockquote>
                <pre
                    class="json"><code id="execution-response-content-GETapi-download-book--author---book-"></code></pre>
            </span>
            <span id="execution-error-GETapi-download-book--author---book-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-download-book--author---book-"></code></pre>
            </span>
            <form id="form-GETapi-download-book--author---book-" data-method="GET"
                data-path="api/download/book/{author}/{book}" data-authed="0" data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-download-book--author---book-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-download-book--author---book-"
                        onclick="tryItOut('GETapi-download-book--author---book-');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-download-book--author---book-"
                        onclick="cancelTryOut('GETapi-download-book--author---book-');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-download-book--author---book-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/download/book/{author}/{book}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>author</code></b>&nbsp;&nbsp;<small>integer</small> &nbsp;
                    <input type="number" name="author" data-endpoint="GETapi-download-book--author---book-"
                        data-component="url" required hidden>
                    <br>
                </p>
                <p>
                    <b><code>book</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="book" data-endpoint="GETapi-download-book--author---book-"
                        data-component="url" required hidden>
                    <br>
                </p>
            </form>

            <h2 id="download-GETapi-download-serie--author---serie-">GET api/download/serie/{author}/{serie}</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-download-serie--author---serie-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/download/serie/1/velit" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/download/serie/1/velit"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-download-serie--author---serie-">
                <blockquote>
                    <p>Example response (404):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4981
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Author].&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
    &quot;line&quot;: 383,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
            &quot;line&quot;: 332,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/nunomaduro\/collision\/src\/Adapters\/Laravel\/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 130,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-download-serie--author---serie-" hidden>
                <blockquote>Received response<span
                        id="execution-response-status-GETapi-download-serie--author---serie-"></span>:
                </blockquote>
                <pre
                    class="json"><code id="execution-response-content-GETapi-download-serie--author---serie-"></code></pre>
            </span>
            <span id="execution-error-GETapi-download-serie--author---serie-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-download-serie--author---serie-"></code></pre>
            </span>
            <form id="form-GETapi-download-serie--author---serie-" data-method="GET"
                data-path="api/download/serie/{author}/{serie}" data-authed="0" data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-download-serie--author---serie-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-download-serie--author---serie-"
                        onclick="tryItOut('GETapi-download-serie--author---serie-');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-download-serie--author---serie-"
                        onclick="cancelTryOut('GETapi-download-serie--author---serie-');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-download-serie--author---serie-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/download/serie/{author}/{serie}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>author</code></b>&nbsp;&nbsp;<small>integer</small> &nbsp;
                    <input type="number" name="author" data-endpoint="GETapi-download-serie--author---serie-"
                        data-component="url" required hidden>
                    <br>
                </p>
                <p>
                    <b><code>serie</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="serie" data-endpoint="GETapi-download-serie--author---serie-"
                        data-component="url" required hidden>
                    <br>
                </p>
            </form>

            <h2 id="download-GETapi-download-author--author-">GET api/download/author/{author}</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-download-author--author-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/download/author/14" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/download/author/14"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-download-author--author-">
                <blockquote>
                    <p>Example response (404):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4980
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Author].&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
    &quot;line&quot;: 383,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
            &quot;line&quot;: 332,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/nunomaduro\/collision\/src\/Adapters\/Laravel\/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 130,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-download-author--author-" hidden>
                <blockquote>Received response<span
                        id="execution-response-status-GETapi-download-author--author-"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-download-author--author-"></code></pre>
            </span>
            <span id="execution-error-GETapi-download-author--author-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-download-author--author-"></code></pre>
            </span>
            <form id="form-GETapi-download-author--author-" data-method="GET" data-path="api/download/author/{author}"
                data-authed="0" data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-download-author--author-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-download-author--author-"
                        onclick="tryItOut('GETapi-download-author--author-');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-download-author--author-"
                        onclick="cancelTryOut('GETapi-download-author--author-');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-download-author--author-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/download/author/{author}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>author</code></b>&nbsp;&nbsp;<small>integer</small> &nbsp;
                    <input type="number" name="author" data-endpoint="GETapi-download-author--author-"
                        data-component="url" required hidden>
                    <br>
                </p>
            </form>

            <h1 id="endpoints">Endpoints</h1>



            <h2 id="endpoints-POSTapi-login">Attempt to authenticate a new session.</h2>

            <p>
            </p>



            <span id="example-requests-POSTapi-login">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"ab\",
    \"password\": \"ab\"
}"
</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "ab",
    "password": "ab"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-POSTapi-login">
            </span>
            <span id="execution-results-POSTapi-login" hidden>
                <blockquote>Received response<span id="execution-response-status-POSTapi-login"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-POSTapi-login"></code></pre>
            </span>
            <span id="execution-error-POSTapi-login" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-POSTapi-login"></code></pre>
            </span>
            <form id="form-POSTapi-login" data-method="POST" data-path="api/login" data-authed="0" data-hasfiles="0"
                data-isarraybody="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
                autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-login', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-POSTapi-login" onclick="tryItOut('POSTapi-login');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-POSTapi-login" onclick="cancelTryOut('POSTapi-login');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-POSTapi-login" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-black">POST</small>
                    <b><code>api/login</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
                <p>
                    <b><code>email</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="email" data-endpoint="POSTapi-login" data-component="body" required hidden>
                    <br>
                </p>
                <p>
                    <b><code>password</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="password" data-endpoint="POSTapi-login" data-component="body" required
                        hidden>
                    <br>
                </p>

            </form>

            <h2 id="endpoints-POSTapi-logout">Destroy an authenticated session.</h2>

            <p>
            </p>



            <span id="example-requests-POSTapi-logout">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/logout" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/logout"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-POSTapi-logout">
            </span>
            <span id="execution-results-POSTapi-logout" hidden>
                <blockquote>Received response<span id="execution-response-status-POSTapi-logout"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-POSTapi-logout"></code></pre>
            </span>
            <span id="execution-error-POSTapi-logout" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-POSTapi-logout"></code></pre>
            </span>
            <form id="form-POSTapi-logout" data-method="POST" data-path="api/logout" data-authed="0" data-hasfiles="0"
                data-isarraybody="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
                autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-logout', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-POSTapi-logout" onclick="tryItOut('POSTapi-logout');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-POSTapi-logout" onclick="cancelTryOut('POSTapi-logout');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-POSTapi-logout" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-black">POST</small>
                    <b><code>api/logout</code></b>
                </p>
            </form>

            <h2 id="endpoints-POSTapi-register">Create a new registered user.</h2>

            <p>
            </p>



            <span id="example-requests-POSTapi-register">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-POSTapi-register">
            </span>
            <span id="execution-results-POSTapi-register" hidden>
                <blockquote>Received response<span id="execution-response-status-POSTapi-register"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-POSTapi-register"></code></pre>
            </span>
            <span id="execution-error-POSTapi-register" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-POSTapi-register"></code></pre>
            </span>
            <form id="form-POSTapi-register" data-method="POST" data-path="api/register" data-authed="0"
                data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('POSTapi-register', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-POSTapi-register" onclick="tryItOut('POSTapi-register');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-POSTapi-register" onclick="cancelTryOut('POSTapi-register');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-POSTapi-register" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-black">POST</small>
                    <b><code>api/register</code></b>
                </p>
            </form>

            <h2 id="endpoints-GETapi-user-confirmed-password-status">Get the password confirmation status.</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-user-confirmed-password-status">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/user/confirmed-password-status" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/user/confirmed-password-status"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-user-confirmed-password-status">
                <blockquote>
                    <p>Example response (401):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
set-cookie: XSRF-TOKEN=eyJpdiI6ImYwOHR4UWZtUFZZckZFNk04U1VmeXc9PSIsInZhbHVlIjoiT2dMUUpucklQSCtTc3V2eDhhck9ueDVjZDc0VE9BU2tkZmc3NkJMNk5JdTVRdExDVTYzcE9JTlZuS3Z3ekhOZ3BSeWhYRzdjOXdPTE1TWTMxai8rQk13SFZZZzRtWUpKbDNkNGtrTXBaUkVjbmt5VklLRVJSWFBYS3B5bTJsR3YiLCJtYWMiOiI0ZWUyMGE5MGYxNmFiOTJmMWU4MGU3YjgwNTVlMmU5OWRjODdiMTJjOTE0NWEwZGRkMTM4ZGIzMWEyYThjZTcwIn0%3D; expires=Thu, 15-Jul-2021 11:10:15 GMT; Max-Age=86400; path=/; domain=localhost; samesite=lax; bookshelves_session=eyJpdiI6IlBmdWNjZkN6UXYwUUpBL0VXcGZVWUE9PSIsInZhbHVlIjoib3Y2Y0lTaTNZeXh1WEh2MmFiM3BUNFFSUk9yOTl5WGpBL09KOFBJR1laeDhQbUM2WEU5d2Q2Sk00Z0hsRUp4STJ4VmpyKzRLUUJkd2dYU2JuWU05ZS9TM0c5alB2UENjR3Frc2RZK1kwU0R3eDN3VC9zV2FEemhmTlRQejl0eXAiLCJtYWMiOiJjZjUzN2I4ZDJmNmFkZDY0YTZlZjlkZGJhNDVmNTMzZWY0ZThkYzczYTA0OGQwOTcxZDIwMzcwMGVhYzBlMDMxIn0%3D; expires=Thu, 15-Jul-2021 11:10:15 GMT; Max-Age=86400; path=/; domain=localhost; httponly; samesite=lax
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-user-confirmed-password-status" hidden>
                <blockquote>Received response<span
                        id="execution-response-status-GETapi-user-confirmed-password-status"></span>:
                </blockquote>
                <pre
                    class="json"><code id="execution-response-content-GETapi-user-confirmed-password-status"></code></pre>
            </span>
            <span id="execution-error-GETapi-user-confirmed-password-status" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-user-confirmed-password-status"></code></pre>
            </span>
            <form id="form-GETapi-user-confirmed-password-status" data-method="GET"
                data-path="api/user/confirmed-password-status" data-authed="0" data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-user-confirmed-password-status', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-user-confirmed-password-status"
                        onclick="tryItOut('GETapi-user-confirmed-password-status');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-user-confirmed-password-status"
                        onclick="cancelTryOut('GETapi-user-confirmed-password-status');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-user-confirmed-password-status" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/user/confirmed-password-status</code></b>
                </p>
            </form>

            <h2 id="endpoints-POSTapi-user-confirm-password">Confirm the user&#039;s password.</h2>

            <p>
            </p>



            <span id="example-requests-POSTapi-user-confirm-password">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/user/confirm-password" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/user/confirm-password"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-POSTapi-user-confirm-password">
            </span>
            <span id="execution-results-POSTapi-user-confirm-password" hidden>
                <blockquote>Received response<span id="execution-response-status-POSTapi-user-confirm-password"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-POSTapi-user-confirm-password"></code></pre>
            </span>
            <span id="execution-error-POSTapi-user-confirm-password" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-POSTapi-user-confirm-password"></code></pre>
            </span>
            <form id="form-POSTapi-user-confirm-password" data-method="POST" data-path="api/user/confirm-password"
                data-authed="0" data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('POSTapi-user-confirm-password', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-POSTapi-user-confirm-password"
                        onclick="tryItOut('POSTapi-user-confirm-password');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-POSTapi-user-confirm-password"
                        onclick="cancelTryOut('POSTapi-user-confirm-password');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-POSTapi-user-confirm-password" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-black">POST</small>
                    <b><code>api/user/confirm-password</code></b>
                </p>
            </form>

            <h2 id="endpoints-GETapi-sanctum-csrf-cookie">Return an empty response simply to trigger the storage of the
                CSRF cookie in the browser.</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-sanctum-csrf-cookie">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/sanctum/csrf-cookie" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/sanctum/csrf-cookie"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-sanctum-csrf-cookie">
                <blockquote>
                    <p>Example response (204):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
vary: Origin
set-cookie: XSRF-TOKEN=eyJpdiI6InNIcVdtU21OYkNPNmFlZ1ltYVdUOFE9PSIsInZhbHVlIjoiK1NmNUxsQ2FzTEtZLzdUTlFoRkR4MWc3RnhZN3lLbnppK2daNmw5aXlKTGsrZXIrRVRTRGFndGdrUC8vRXJJbGhxcDVsdHk3T2tsRU1uSHgzMnZJbVRJUDkwUkhjcUhkb3ZSZVR0QlZnakJGQ1ppTVJlWWpQTTZjbWc1RWtMYXciLCJtYWMiOiI5YTNkYWRlNzM1NDUzMmQ0MTg1OTI1MWRhYTFkM2VjNmVmZDg1NzU4MTliYzJiNmY0NTBhZjJiM2UyMmYyZTkwIn0%3D; expires=Thu, 15-Jul-2021 11:10:15 GMT; Max-Age=86400; path=/; domain=localhost; samesite=lax; bookshelves_session=eyJpdiI6InNxYi96anptZ3lZVzhoQ21ZNkhzcmc9PSIsInZhbHVlIjoiYk16UVRDcGROb0J6NkZ5Z3lHZUxDcmdNY3V5NG1sem9hb0FwbGpkSndodkhxNG5ORERzQzl4NHNMRitNYWxIT0ViWDZzWXFyT1ZOQWJ0dWpSanpzaE9xU1FjNkc4UXZERmh0NkNBbjZVY25VZHhLeG40VGRCNnE5ekxvQWFJQmsiLCJtYWMiOiJlMmU0ZGU3YTJjZTdiZmI1M2RhMTYzZGZlN2VmNzQ5YmUyYjQxOWMyMmZhMjliYjVjOWFhNTEzYTEyMDQ1YzdhIn0%3D; expires=Thu, 15-Jul-2021 11:10:15 GMT; Max-Age=86400; path=/; domain=localhost; httponly; samesite=lax
 </code></pre>
                </details>
                <pre>
<code>[Empty response]</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-sanctum-csrf-cookie" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-sanctum-csrf-cookie"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-sanctum-csrf-cookie"></code></pre>
            </span>
            <span id="execution-error-GETapi-sanctum-csrf-cookie" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-sanctum-csrf-cookie"></code></pre>
            </span>
            <form id="form-GETapi-sanctum-csrf-cookie" data-method="GET" data-path="api/sanctum/csrf-cookie"
                data-authed="0" data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-sanctum-csrf-cookie', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-sanctum-csrf-cookie" onclick="tryItOut('GETapi-sanctum-csrf-cookie');">Try
                        it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-sanctum-csrf-cookie"
                        onclick="cancelTryOut('GETapi-sanctum-csrf-cookie');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-sanctum-csrf-cookie" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/sanctum/csrf-cookie</code></b>
                </p>
            </form>

            <h2 id="endpoints-GETapi-count">GET api/count</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-count">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/count" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/count"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-count">
                <blockquote>
                    <p>Example response (400):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4988
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">&quot;Invalid 'entity' query parameter, must be like 'book' or 'serie' or 'author'&quot;</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-count" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-count"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-count"></code></pre>
            </span>
            <span id="execution-error-GETapi-count" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-count"></code></pre>
            </span>
            <form id="form-GETapi-count" data-method="GET" data-path="api/count" data-authed="0" data-hasfiles="0"
                data-isarraybody="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
                autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-count', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-count" onclick="tryItOut('GETapi-count');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-count" onclick="cancelTryOut('GETapi-count');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-count" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/count</code></b>
                </p>
            </form>

            <h1 id="language">Language</h1>



            <h2 id="language-GETapi-languages">GET api/languages</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-languages">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/languages" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/languages"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-languages">
                <blockquote>
                    <p>Example response (200):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4971
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;name&quot;: &quot;French&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;fr&quot;
            }
        },
        {
            &quot;name&quot;: &quot;English&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;en&quot;
            }
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-languages" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-languages"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-languages"></code></pre>
            </span>
            <span id="execution-error-GETapi-languages" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-languages"></code></pre>
            </span>
            <form id="form-GETapi-languages" data-method="GET" data-path="api/languages" data-authed="0"
                data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-languages', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-languages" onclick="tryItOut('GETapi-languages');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-languages" onclick="cancelTryOut('GETapi-languages');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-languages" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/languages</code></b>
                </p>
            </form>

            <h1 id="publisher">Publisher</h1>



            <h2 id="publisher-GETapi-publishers">GET api/publishers</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-publishers">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/publishers" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/publishers"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-publishers">
                <blockquote>
                    <p>Example response (200):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4974
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;name&quot;: &quot;Actes Sud&quot;,
            &quot;count&quot;: 3,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;actes-sud&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/actes-sud&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/actes-sud&quot;
            }
        },
        {
            &quot;name&quot;: &quot;ActuSF&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;actusf&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/actusf&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/actusf&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Albin Michel&quot;,
            &quot;count&quot;: 4,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;albin-michel&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/albin-michel&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/albin-michel&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Alexandriz&quot;,
            &quot;count&quot;: 58,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;alexandriz&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/alexandriz&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/alexandriz&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Atalante&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;atalante&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/atalante&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/atalante&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Au Diable Vauvert&quot;,
            &quot;count&quot;: 7,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;au-diable-vauvert&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/au-diable-vauvert&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/au-diable-vauvert&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Bayard&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;bayard&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/bayard&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/bayard&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Bayard Jeunesse&quot;,
            &quot;count&quot;: 13,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;bayard-jeunesse&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/bayard-jeunesse&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/bayard-jeunesse&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Berkley Sensation&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;berkley-sensation&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/berkley-sensation&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/berkley-sensation&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Biquette&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;biquette&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/biquette&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/biquette&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Bourgois&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;bourgois&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/bourgois&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/bourgois&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Bragelone&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;bragelone&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/bragelone&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/bragelone&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Bragelonne&quot;,
            &quot;count&quot;: 52,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;bragelonne&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/bragelonne&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/bragelonne&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Broadview Press&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;broadview-press&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/broadview-press&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/broadview-press&quot;
            }
        },
        {
            &quot;name&quot;: &quot;C. Bourgois&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;c-bourgois&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/c-bourgois&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/c-bourgois&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Claude Lefrancq&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;claude-lefrancq&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/claude-lefrancq&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/claude-lefrancq&quot;
            }
        },
        {
            &quot;name&quot;: &quot;CreateSpace Independent Publishing Platform&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;createspace-independent-publishing-platform&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/createspace-independent-publishing-platform&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/createspace-independent-publishing-platform&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Critic&quot;,
            &quot;count&quot;: 3,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;critic&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/critic&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/critic&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Deno&euml;l&quot;,
            &quot;count&quot;: 11,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;denoel&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/denoel&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/denoel&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Domaine public&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;domaine-public&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/domaine-public&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/domaine-public&quot;
            }
        },
        {
            &quot;name&quot;: &quot;e-artnow&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;e-artnow&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/e-artnow&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/e-artnow&quot;
            }
        },
        {
            &quot;name&quot;: &quot;edi8&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;edi8&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/edi8&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/edi8&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Editions 84&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;editions-84&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/editions-84&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/editions-84&quot;
            }
        },
        {
            &quot;name&quot;: &quot;&Eacute;ditions France loisirs&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;editions-france-loisirs&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/editions-france-loisirs&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/editions-france-loisirs&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Editions Gallimard&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;editions-gallimard&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/editions-gallimard&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/editions-gallimard&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Editions La Branche&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;editions-la-branche&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/editions-la-branche&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/editions-la-branche&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Feedbooks&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;feedbooks&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/feedbooks&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/feedbooks&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Flammarion&quot;,
            &quot;count&quot;: 9,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;flammarion&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/flammarion&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/flammarion&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Flammarion jeunesse&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;flammarion-jeunesse&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/flammarion-jeunesse&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/flammarion-jeunesse&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Fleuve &Eacute;ditions&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;fleuve-editions&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/fleuve-editions&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/fleuve-editions&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Fleuve Noir&quot;,
            &quot;count&quot;: 65,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;fleuve-noir&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/fleuve-noir&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/fleuve-noir&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Folio SF&quot;,
            &quot;count&quot;: 5,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;folio-sf&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/folio-sf&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/folio-sf&quot;
            }
        },
        {
            &quot;name&quot;: &quot;France Loisirs&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;france-loisirs&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/france-loisirs&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/france-loisirs&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Gallimard&quot;,
            &quot;count&quot;: 6,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;gallimard&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/gallimard&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/gallimard&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Gallimard Jeunesse&quot;,
            &quot;count&quot;: 14,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;gallimard-jeunesse&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/gallimard-jeunesse&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/gallimard-jeunesse&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Hachette UK&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;hachette-uk&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/hachette-uk&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/hachette-uk&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Harlequin&quot;,
            &quot;count&quot;: 3,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;harlequin&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/harlequin&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/harlequin&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Hauteville&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;hauteville&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/hauteville&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/hauteville&quot;
            }
        },
        {
            &quot;name&quot;: &quot;H&eacute;r&eacute;tiques&quot;,
            &quot;count&quot;: 3,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;heretiques&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/heretiques&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/heretiques&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Institut Nazareth et Louis-Braille&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;institut-nazareth-et-louis-braille&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/institut-nazareth-et-louis-braille&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/institut-nazareth-et-louis-braille&quot;
            }
        },
        {
            &quot;name&quot;: &quot;J'ai lu&quot;,
            &quot;count&quot;: 29,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;jai-lu&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/jai-lu&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/jai-lu&quot;
            }
        },
        {
            &quot;name&quot;: &quot;J'ai Lu Science-Fiction&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;jai-lu-science-fiction&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/jai-lu-science-fiction&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/jai-lu-science-fiction&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Jay Bell&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;jay-bell&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/jay-bell&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/jay-bell&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Jay Bell Books&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;jay-bell-books&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/jay-bell-books&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/jay-bell-books&quot;
            }
        },
        {
            &quot;name&quot;: &quot;L'Atalante&quot;,
            &quot;count&quot;: 51,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;latalante&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/latalante&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/latalante&quot;
            }
        },
        {
            &quot;name&quot;: &quot;La Volte&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;la-volte&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/la-volte&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/la-volte&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Le B&eacute;lial&quot;,
            &quot;count&quot;: 3,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;le-belial&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/le-belial&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/le-belial&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Librairie Des Champs-elysees&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;librairie-des-champs-elysees&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/librairie-des-champs-elysees&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/librairie-des-champs-elysees&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Librairie L' Atalante&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;librairie-l-atalante&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/librairie-l-atalante&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/librairie-l-atalante&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Librairie L'Atalante&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;librairie-latalante&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/librairie-latalante&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/librairie-latalante&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Little Brown-usa&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;little-brown-usa&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/little-brown-usa&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/little-brown-usa&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Milady&quot;,
            &quot;count&quot;: 15,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;milady&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/milady&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/milady&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Mira Ink&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;mira-ink&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/mira-ink&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/mira-ink&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Mn&eacute;mos&quot;,
            &quot;count&quot;: 5,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;mnemos&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/mnemos&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/mnemos&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Panini&quot;,
            &quot;count&quot;: 3,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;panini&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/panini&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/panini&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Penguin&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;penguin&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/penguin&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/penguin&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Penguin Group USA&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;penguin-group-usa&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/penguin-group-usa&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/penguin-group-usa&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Place des &eacute;diteurs&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;place-des-editeurs&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/place-des-editeurs&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/place-des-editeurs&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Pocket&quot;,
            &quot;count&quot;: 15,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;pocket&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/pocket&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/pocket&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Pocket jeunesse&quot;,
            &quot;count&quot;: 15,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;pocket-jeunesse&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/pocket-jeunesse&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/pocket-jeunesse&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Pottermore&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;pottermore&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/pottermore&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/pottermore&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Presses de la cit&eacute;&quot;,
            &quot;count&quot;: 7,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;presses-de-la-cite&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/presses-de-la-cite&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/presses-de-la-cite&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Presses pocket&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;presses-pocket&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/presses-pocket&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/presses-pocket&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Pygmalion&quot;,
            &quot;count&quot;: 57,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;pygmalion&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/pygmalion&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/pygmalion&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Rageot&quot;,
            &quot;count&quot;: 14,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;rageot&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/rageot&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/rageot&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Sahara Publisher Books&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;sahara-publisher-books&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/sahara-publisher-books&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/sahara-publisher-books&quot;
            }
        },
        {
            &quot;name&quot;: &quot;St. Martin&rsquo;s Press&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;st-martins-press&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/st-martins-press&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/st-martins-press&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Thriller Editions&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;thriller-editions&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/thriller-editions&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/thriller-editions&quot;
            }
        },
        {
            &quot;name&quot;: &quot;TKA Distribution&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;tka-distribution&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/tka-distribution&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/tka-distribution&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Union g&eacute;n&eacute;rale d'&eacute;ditions&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;union-generale-deditions&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/union-generale-deditions&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/union-generale-deditions&quot;
            }
        },
        {
            &quot;name&quot;: &quot;UNIVERS POCHE&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;univers-poche&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/univers-poche&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/univers-poche&quot;
            }
        },
        {
            &quot;name&quot;: &quot;VOLTE&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;volte&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/volte&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/volte&quot;
            }
        },
        {
            &quot;name&quot;: &quot;XO&quot;,
            &quot;count&quot;: 13,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;xo&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/books\/xo&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/publishers\/xo&quot;
            }
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-publishers" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-publishers"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-publishers"></code></pre>
            </span>
            <span id="execution-error-GETapi-publishers" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-publishers"></code></pre>
            </span>
            <form id="form-GETapi-publishers" data-method="GET" data-path="api/publishers" data-authed="0"
                data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-publishers', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-publishers" onclick="tryItOut('GETapi-publishers');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-publishers" onclick="cancelTryOut('GETapi-publishers');"
                        hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-publishers" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/publishers</code></b>
                </p>
            </form>

            <h2 id="publisher-GETapi-publishers--id-">GET api/publishers/{id}</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-publishers--id-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/publishers/7" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/publishers/7"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-publishers--id-">
                <blockquote>
                    <p>Example response (404):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4973
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Publisher].&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
    &quot;line&quot;: 383,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
            &quot;line&quot;: 332,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/nunomaduro\/collision\/src\/Adapters\/Laravel\/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 130,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-publishers--id-" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-publishers--id-"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-publishers--id-"></code></pre>
            </span>
            <span id="execution-error-GETapi-publishers--id-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-publishers--id-"></code></pre>
            </span>
            <form id="form-GETapi-publishers--id-" data-method="GET" data-path="api/publishers/{id}" data-authed="0"
                data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-publishers--id-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-publishers--id-" onclick="tryItOut('GETapi-publishers--id-');">Try it out
                        ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-publishers--id-" onclick="cancelTryOut('GETapi-publishers--id-');"
                        hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-publishers--id-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/publishers/{id}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small> &nbsp;
                    <input type="number" name="id" data-endpoint="GETapi-publishers--id-" data-component="url" required
                        hidden>
                    <br>
                <p>The ID of the publisher.</p>
                </p>
            </form>

            <h2 id="publisher-GETapi-publishers-books--publisher-">GET api/publishers/books/{publisher}</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-publishers-books--publisher-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/publishers/books/2" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/publishers/books/2"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-publishers-books--publisher-">
                <blockquote>
                    <p>Example response (404):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4972
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Publisher].&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
    &quot;line&quot;: 383,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
            &quot;line&quot;: 332,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/nunomaduro\/collision\/src\/Adapters\/Laravel\/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 130,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-publishers-books--publisher-" hidden>
                <blockquote>Received response<span
                        id="execution-response-status-GETapi-publishers-books--publisher-"></span>:
                </blockquote>
                <pre
                    class="json"><code id="execution-response-content-GETapi-publishers-books--publisher-"></code></pre>
            </span>
            <span id="execution-error-GETapi-publishers-books--publisher-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-publishers-books--publisher-"></code></pre>
            </span>
            <form id="form-GETapi-publishers-books--publisher-" data-method="GET"
                data-path="api/publishers/books/{publisher}" data-authed="0" data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-publishers-books--publisher-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-publishers-books--publisher-"
                        onclick="tryItOut('GETapi-publishers-books--publisher-');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-publishers-books--publisher-"
                        onclick="cancelTryOut('GETapi-publishers-books--publisher-');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-publishers-books--publisher-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/publishers/books/{publisher}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>publisher</code></b>&nbsp;&nbsp;<small>integer</small> &nbsp;
                    <input type="number" name="publisher" data-endpoint="GETapi-publishers-books--publisher-"
                        data-component="url" required hidden>
                    <br>
                </p>
            </form>

            <h1 id="search">Search</h1>



            <h2 id="search-GETapi-search">GET api/search</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-search">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/search" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/search"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-search">
                <blockquote>
                    <p>Example response (401):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4987
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;error&quot;: &quot;Need to have terms query parameter&quot;
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-search" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-search"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-search"></code></pre>
            </span>
            <span id="execution-error-GETapi-search" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-search"></code></pre>
            </span>
            <form id="form-GETapi-search" data-method="GET" data-path="api/search" data-authed="0" data-hasfiles="0"
                data-isarraybody="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
                autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-search', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-search" onclick="tryItOut('GETapi-search');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-search" onclick="cancelTryOut('GETapi-search');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-search" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/search</code></b>
                </p>
            </form>

            <h2 id="search-GETapi-search-books">GET api/search/books</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-search-books">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/search/books" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/search/books"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-search-books">
                <blockquote>
                    <p>Example response (500):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4986
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder::App\\Providers\\{closure}(): Argument #2 ($searchTerm) must be of type string, null given, called in \/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Builder.php on line 1609&quot;,
    &quot;exception&quot;: &quot;TypeError&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/app\/Providers\/AppServiceProvider.php&quot;,
    &quot;line&quot;: 20,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Builder.php&quot;,
            &quot;line&quot;: 1609,
            &quot;function&quot;: &quot;App\\Providers\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Support\/Traits\/ForwardsCalls.php&quot;,
            &quot;line&quot;: 23,
            &quot;function&quot;: &quot;__call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Model.php&quot;,
            &quot;line&quot;: 2000,
            &quot;function&quot;: &quot;forwardCallTo&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Model.php&quot;,
            &quot;line&quot;: 2012,
            &quot;function&quot;: &quot;__call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/app\/Http\/Controllers\/Api\/SearchController.php&quot;,
            &quot;line&quot;: 63,
            &quot;function&quot;: &quot;__callStatic&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;books&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\Api\\SearchController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;callAction&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Controller&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php&quot;,
            &quot;line&quot;: 254,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\ControllerDispatcher&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php&quot;,
            &quot;line&quot;: 197,
            &quot;function&quot;: &quot;runController&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 695,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Routing\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-search-books" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-search-books"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-search-books"></code></pre>
            </span>
            <span id="execution-error-GETapi-search-books" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-search-books"></code></pre>
            </span>
            <form id="form-GETapi-search-books" data-method="GET" data-path="api/search/books" data-authed="0"
                data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-search-books', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-search-books" onclick="tryItOut('GETapi-search-books');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-search-books" onclick="cancelTryOut('GETapi-search-books');"
                        hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-search-books" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/search/books</code></b>
                </p>
            </form>

            <h2 id="search-GETapi-search-authors">GET api/search/authors</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-search-authors">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/search/authors" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/search/authors"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-search-authors">
                <blockquote>
                    <p>Example response (500):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4985
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder::App\\Providers\\{closure}(): Argument #2 ($searchTerm) must be of type string, null given, called in \/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Builder.php on line 1609&quot;,
    &quot;exception&quot;: &quot;TypeError&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/app\/Providers\/AppServiceProvider.php&quot;,
    &quot;line&quot;: 20,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Builder.php&quot;,
            &quot;line&quot;: 1609,
            &quot;function&quot;: &quot;App\\Providers\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Support\/Traits\/ForwardsCalls.php&quot;,
            &quot;line&quot;: 23,
            &quot;function&quot;: &quot;__call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Model.php&quot;,
            &quot;line&quot;: 2000,
            &quot;function&quot;: &quot;forwardCallTo&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Model.php&quot;,
            &quot;line&quot;: 2012,
            &quot;function&quot;: &quot;__call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/app\/Http\/Controllers\/Api\/SearchController.php&quot;,
            &quot;line&quot;: 72,
            &quot;function&quot;: &quot;__callStatic&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;authors&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\Api\\SearchController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;callAction&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Controller&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php&quot;,
            &quot;line&quot;: 254,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\ControllerDispatcher&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php&quot;,
            &quot;line&quot;: 197,
            &quot;function&quot;: &quot;runController&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 695,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Routing\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-search-authors" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-search-authors"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-search-authors"></code></pre>
            </span>
            <span id="execution-error-GETapi-search-authors" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-search-authors"></code></pre>
            </span>
            <form id="form-GETapi-search-authors" data-method="GET" data-path="api/search/authors" data-authed="0"
                data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-search-authors', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-search-authors" onclick="tryItOut('GETapi-search-authors');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-search-authors" onclick="cancelTryOut('GETapi-search-authors');"
                        hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-search-authors" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/search/authors</code></b>
                </p>
            </form>

            <h2 id="search-GETapi-search-series">GET api/search/series</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-search-series">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/search/series" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/search/series"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-search-series">
                <blockquote>
                    <p>Example response (500):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4984
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder::App\\Providers\\{closure}(): Argument #2 ($searchTerm) must be of type string, null given, called in \/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Builder.php on line 1609&quot;,
    &quot;exception&quot;: &quot;TypeError&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/app\/Providers\/AppServiceProvider.php&quot;,
    &quot;line&quot;: 20,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Builder.php&quot;,
            &quot;line&quot;: 1609,
            &quot;function&quot;: &quot;App\\Providers\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Support\/Traits\/ForwardsCalls.php&quot;,
            &quot;line&quot;: 23,
            &quot;function&quot;: &quot;__call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Model.php&quot;,
            &quot;line&quot;: 2000,
            &quot;function&quot;: &quot;forwardCallTo&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Model.php&quot;,
            &quot;line&quot;: 2012,
            &quot;function&quot;: &quot;__call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/app\/Http\/Controllers\/Api\/SearchController.php&quot;,
            &quot;line&quot;: 80,
            &quot;function&quot;: &quot;__callStatic&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;series&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\Api\\SearchController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;callAction&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Controller&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php&quot;,
            &quot;line&quot;: 254,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\ControllerDispatcher&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php&quot;,
            &quot;line&quot;: 197,
            &quot;function&quot;: &quot;runController&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 695,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Routing\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-search-series" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-search-series"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-search-series"></code></pre>
            </span>
            <span id="execution-error-GETapi-search-series" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-search-series"></code></pre>
            </span>
            <form id="form-GETapi-search-series" data-method="GET" data-path="api/search/series" data-authed="0"
                data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-search-series', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-search-series" onclick="tryItOut('GETapi-search-series');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-search-series" onclick="cancelTryOut('GETapi-search-series');"
                        hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-search-series" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/search/series</code></b>
                </p>
            </form>

            <h2 id="search-GETapi-search-advanced">GET api/search/advanced</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-search-advanced">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/search/advanced" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/search/advanced"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-search-advanced">
                <blockquote>
                    <p>Example response (401):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4983
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;error&quot;: &quot;Need to have terms query parameter&quot;
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-search-advanced" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-search-advanced"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-search-advanced"></code></pre>
            </span>
            <span id="execution-error-GETapi-search-advanced" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-search-advanced"></code></pre>
            </span>
            <form id="form-GETapi-search-advanced" data-method="GET" data-path="api/search/advanced" data-authed="0"
                data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-search-advanced', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-search-advanced" onclick="tryItOut('GETapi-search-advanced');">Try it out
                        ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-search-advanced" onclick="cancelTryOut('GETapi-search-advanced');"
                        hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-search-advanced" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/search/advanced</code></b>
                </p>
            </form>

            <h1 id="serie">Serie</h1>



            <h2 id="serie-GETapi-series">GET api/series</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-series">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/series" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/series"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-series">
                <blockquote>
                    <p>Example response (200):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4996
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;title&quot;: &quot;A comme Association&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;a-comme-association-fr&quot;,
                &quot;author&quot;: &quot;bottero-pierre&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/bottero-pierre\/a-comme-association-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/bottero-pierre\/a-comme-association-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1127\/conversions\/a-comme-association-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1127\/conversions\/a-comme-association-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#26366b&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Pierre Bottero&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;bottero-pierre&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/bottero-pierre&quot;
                    }
                },
                {
                    &quot;name&quot;: &quot;Erik L'Homme&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;lhomme-erik&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/lhomme-erik&quot;
                    }
                }
            ],
            &quot;count&quot;: 8
        },
        {
            &quot;title&quot;: &quot;Les Annales du Disque-Monde&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-annales-du-disque-monde-fr&quot;,
                &quot;author&quot;: &quot;pratchett-terry&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/pratchett-terry\/les-annales-du-disque-monde-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1128\/conversions\/les-annales-du-disque-monde-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1128\/conversions\/les-annales-du-disque-monde-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#48495e&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Terry Pratchett&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;pratchett-terry&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/pratchett-terry&quot;
                    }
                }
            ],
            &quot;count&quot;: 34
        },
        {
            &quot;title&quot;: &quot;Artemis Fowl&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;artemis-fowl-fr&quot;,
                &quot;author&quot;: &quot;colfer-eoin&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/colfer-eoin\/artemis-fowl-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/colfer-eoin\/artemis-fowl-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1129\/conversions\/artemis-fowl-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1129\/conversions\/artemis-fowl-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#987617&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Eoin Colfer&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;colfer-eoin&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/colfer-eoin&quot;
                    }
                }
            ],
            &quot;count&quot;: 8
        },
        {
            &quot;title&quot;: &quot;L'Assassin Royal&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;lassassin-royal-fr&quot;,
                &quot;author&quot;: &quot;hobb-robin&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/hobb-robin\/lassassin-royal-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/hobb-robin\/lassassin-royal-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1130\/conversions\/lassassin-royal-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1130\/conversions\/lassassin-royal-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#627268&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Robin Hobb&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;hobb-robin&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/hobb-robin&quot;
                    }
                }
            ],
            &quot;count&quot;: 13
        },
        {
            &quot;title&quot;: &quot;L'Autre&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;lautre-fr&quot;,
                &quot;author&quot;: &quot;bottero-pierre&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/bottero-pierre\/lautre-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/bottero-pierre\/lautre-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1131\/conversions\/lautre-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1131\/conversions\/lautre-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#6a5646&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Pierre Bottero&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;bottero-pierre&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/bottero-pierre&quot;
                    }
                }
            ],
            &quot;count&quot;: 3
        },
        {
            &quot;title&quot;: &quot;Les Aventuriers de la mer&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-aventuriers-de-la-mer-fr&quot;,
                &quot;author&quot;: &quot;hobb-robin&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/hobb-robin\/les-aventuriers-de-la-mer-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/hobb-robin\/les-aventuriers-de-la-mer-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1132\/conversions\/les-aventuriers-de-la-mer-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1132\/conversions\/les-aventuriers-de-la-mer-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#466e81&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Robin Hobb&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;hobb-robin&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/hobb-robin&quot;
                    }
                }
            ],
            &quot;count&quot;: 10
        },
        {
            &quot;title&quot;: &quot;Beauregard&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;beauregard-fr&quot;,
                &quot;author&quot;: &quot;jubert-herve&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/jubert-herve\/beauregard-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/jubert-herve\/beauregard-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1133\/conversions\/beauregard-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1133\/conversions\/beauregard-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#564923&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Herv&eacute; Jubert&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;jubert-herve&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/jubert-herve&quot;
                    }
                }
            ],
            &quot;count&quot;: 3
        },
        {
            &quot;title&quot;: &quot;Blood Books&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;blood-books-en&quot;,
                &quot;author&quot;: &quot;huff-tanya&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/huff-tanya\/blood-books-en&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/huff-tanya\/blood-books-en&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1134\/conversions\/blood-books-en-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1134\/conversions\/blood-books-en-simple.jpg&quot;,
                &quot;color&quot;: &quot;#302f29&quot;
            },
            &quot;language&quot;: &quot;en&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Tanya Huff&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;huff-tanya&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/huff-tanya&quot;
                    }
                }
            ],
            &quot;count&quot;: 1
        },
        {
            &quot;title&quot;: &quot;Cantos d'Hyperion&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;cantos-dhyperion-fr&quot;,
                &quot;author&quot;: &quot;simmons-dan&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/simmons-dan\/cantos-dhyperion-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/simmons-dan\/cantos-dhyperion-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1135\/conversions\/cantos-dhyperion-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1135\/conversions\/cantos-dhyperion-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#879b90&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Dan Simmons&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;simmons-dan&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/simmons-dan&quot;
                    }
                }
            ],
            &quot;count&quot;: 2
        },
        {
            &quot;title&quot;: &quot;Chasseuse de la nuit&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;chasseuse-de-la-nuit-fr&quot;,
                &quot;author&quot;: &quot;frost-jeaniene&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/frost-jeaniene\/chasseuse-de-la-nuit-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/frost-jeaniene\/chasseuse-de-la-nuit-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1136\/conversions\/chasseuse-de-la-nuit-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1136\/conversions\/chasseuse-de-la-nuit-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#426362&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Jeaniene Frost&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;frost-jeaniene&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/frost-jeaniene&quot;
                    }
                }
            ],
            &quot;count&quot;: 8
        },
        {
            &quot;title&quot;: &quot;Les Chevaliers d'&Eacute;meraude&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-chevaliers-demeraude-fr&quot;,
                &quot;author&quot;: &quot;robillard-anne&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/robillard-anne\/les-chevaliers-demeraude-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/robillard-anne\/les-chevaliers-demeraude-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1137\/conversions\/les-chevaliers-demeraude-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1137\/conversions\/les-chevaliers-demeraude-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#55593a&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Anne Robillard&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;robillard-anne&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/robillard-anne&quot;
                    }
                }
            ],
            &quot;count&quot;: 13
        },
        {
            &quot;title&quot;: &quot;Chroniques de l'Armageddon&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;chroniques-de-larmageddon-fr&quot;,
                &quot;author&quot;: &quot;bourne-j-l&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/bourne-j-l\/chroniques-de-larmageddon-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/bourne-j-l\/chroniques-de-larmageddon-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1138\/conversions\/chroniques-de-larmageddon-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1138\/conversions\/chroniques-de-larmageddon-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#605756&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;J. L. Bourne&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;bourne-j-l&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/bourne-j-l&quot;
                    }
                }
            ],
            &quot;count&quot;: 3
        },
        {
            &quot;title&quot;: &quot;Les Chroniques de Narnia&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-chroniques-de-narnia-fr&quot;,
                &quot;author&quot;: &quot;lewis-clive-staples&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/lewis-clive-staples\/les-chroniques-de-narnia-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/lewis-clive-staples\/les-chroniques-de-narnia-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1139\/conversions\/les-chroniques-de-narnia-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1139\/conversions\/les-chroniques-de-narnia-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#433225&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Clive Staples Lewis&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;lewis-clive-staples&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/lewis-clive-staples&quot;
                    }
                }
            ],
            &quot;count&quot;: 7
        },
        {
            &quot;title&quot;: &quot;Les chroniques des Ravens&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-chroniques-des-ravens-fr&quot;,
                &quot;author&quot;: &quot;barclay-james&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/barclay-james\/les-chroniques-des-ravens-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/barclay-james\/les-chroniques-des-ravens-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1140\/conversions\/les-chroniques-des-ravens-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1140\/conversions\/les-chroniques-des-ravens-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#7d5a3b&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;James Barclay&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;barclay-james&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/barclay-james&quot;
                    }
                }
            ],
            &quot;count&quot;: 3
        },
        {
            &quot;title&quot;: &quot;Chroniques du Monde Emerg&eacute;&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;chroniques-du-monde-emerge-fr&quot;,
                &quot;author&quot;: &quot;troisi-licia&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/troisi-licia\/chroniques-du-monde-emerge-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/troisi-licia\/chroniques-du-monde-emerge-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1141\/conversions\/chroniques-du-monde-emerge-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1141\/conversions\/chroniques-du-monde-emerge-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#3d5354&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Licia Troisi&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;troisi-licia&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/troisi-licia&quot;
                    }
                }
            ],
            &quot;count&quot;: 3
        },
        {
            &quot;title&quot;: &quot;Les Cit&eacute;s des Anciens&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-cites-des-anciens-fr&quot;,
                &quot;author&quot;: &quot;hobb-robin&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/hobb-robin\/les-cites-des-anciens-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/hobb-robin\/les-cites-des-anciens-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1142\/conversions\/les-cites-des-anciens-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1142\/conversions\/les-cites-des-anciens-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#3f412f&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Robin Hobb&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;hobb-robin&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/hobb-robin&quot;
                    }
                }
            ],
            &quot;count&quot;: 8
        },
        {
            &quot;title&quot;: &quot;La Compagnie des glaces&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;la-compagnie-des-glaces-fr&quot;,
                &quot;author&quot;: &quot;arnaud-georges-jean&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/arnaud-georges-jean\/la-compagnie-des-glaces-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/arnaud-georges-jean\/la-compagnie-des-glaces-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1143\/conversions\/la-compagnie-des-glaces-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1143\/conversions\/la-compagnie-des-glaces-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#303331&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Georges-Jean Arnaud&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;arnaud-georges-jean&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/arnaud-georges-jean&quot;
                    }
                }
            ],
            &quot;count&quot;: 60
        },
        {
            &quot;title&quot;: &quot;Cthulhu : Le Mythe&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;cthulhu-le-mythe-fr&quot;,
                &quot;author&quot;: &quot;lovecraft-howard-phillips&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/lovecraft-howard-phillips\/cthulhu-le-mythe-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/lovecraft-howard-phillips\/cthulhu-le-mythe-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1144\/conversions\/cthulhu-le-mythe-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1144\/conversions\/cthulhu-le-mythe-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#806c47&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Howard Phillips Lovecraft&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;lovecraft-howard-phillips&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/lovecraft-howard-phillips&quot;
                    }
                }
            ],
            &quot;count&quot;: 3
        },
        {
            &quot;title&quot;: &quot;Le cycle d'Abzalon&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;le-cycle-dabzalon-fr&quot;,
                &quot;author&quot;: &quot;bordage-pierre&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/bordage-pierre\/le-cycle-dabzalon-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/bordage-pierre\/le-cycle-dabzalon-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1145\/conversions\/le-cycle-dabzalon-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1145\/conversions\/le-cycle-dabzalon-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#757266&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Pierre Bordage&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;bordage-pierre&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/bordage-pierre&quot;
                    }
                }
            ],
            &quot;count&quot;: 2
        },
        {
            &quot;title&quot;: &quot;Le Cycle d'Omale&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;le-cycle-domale-fr&quot;,
                &quot;author&quot;: &quot;genefort-laurent&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/genefort-laurent\/le-cycle-domale-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/genefort-laurent\/le-cycle-domale-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1146\/conversions\/le-cycle-domale-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1146\/conversions\/le-cycle-domale-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#607a82&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Laurent Genefort&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;genefort-laurent&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/genefort-laurent&quot;
                    }
                }
            ],
            &quot;count&quot;: 5
        },
        {
            &quot;title&quot;: &quot;Les derniers hommes&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-derniers-hommes-fr&quot;,
                &quot;author&quot;: &quot;bordage-pierre&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/bordage-pierre\/les-derniers-hommes-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/bordage-pierre\/les-derniers-hommes-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1147\/conversions\/les-derniers-hommes-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1147\/conversions\/les-derniers-hommes-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#717b7c&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Pierre Bordage&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;bordage-pierre&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/bordage-pierre&quot;
                    }
                }
            ],
            &quot;count&quot;: 6
        },
        {
            &quot;title&quot;: &quot;Les D&eacute;sastreuses aventures des orphelins Baudelaire&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-desastreuses-aventures-des-orphelins-baudelaire-fr&quot;,
                &quot;author&quot;: &quot;snicket-lemony&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/snicket-lemony\/les-desastreuses-aventures-des-orphelins-baudelaire-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/snicket-lemony\/les-desastreuses-aventures-des-orphelins-baudelaire-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1148\/conversions\/les-desastreuses-aventures-des-orphelins-baudelaire-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1148\/conversions\/les-desastreuses-aventures-des-orphelins-baudelaire-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#99685a&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Lemony Snicket&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;snicket-lemony&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/snicket-lemony&quot;
                    }
                }
            ],
            &quot;count&quot;: 13
        },
        {
            &quot;title&quot;: &quot;Drena&iuml;&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;drenai-fr&quot;,
                &quot;author&quot;: &quot;gemmell-david&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/gemmell-david\/drenai-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/gemmell-david\/drenai-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1149\/conversions\/drenai-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1149\/conversions\/drenai-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#323432&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;David Gemmell&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;gemmell-david&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/gemmell-david&quot;
                    }
                }
            ],
            &quot;count&quot;: 11
        },
        {
            &quot;title&quot;: &quot;Dune&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;dune-fr&quot;,
                &quot;author&quot;: &quot;herbert-frank&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/herbert-frank\/dune-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/herbert-frank\/dune-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1150\/conversions\/dune-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1150\/conversions\/dune-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#9b897c&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Frank Herbert&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;herbert-frank&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/herbert-frank&quot;
                    }
                }
            ],
            &quot;count&quot;: 6
        },
        {
            &quot;title&quot;: &quot;Empire&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;empire-fr&quot;,
                &quot;author&quot;: &quot;asimov-isaac&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/asimov-isaac\/empire-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/asimov-isaac\/empire-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1151\/conversions\/empire-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1151\/conversions\/empire-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#353234&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Isaac Asimov&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;asimov-isaac&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/asimov-isaac&quot;
                    }
                }
            ],
            &quot;count&quot;: 3
        },
        {
            &quot;title&quot;: &quot;Les Enfants de la Terre&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-enfants-de-la-terre-fr&quot;,
                &quot;author&quot;: &quot;auel-jean-m&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/auel-jean-m\/les-enfants-de-la-terre-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/auel-jean-m\/les-enfants-de-la-terre-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1152\/conversions\/les-enfants-de-la-terre-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1152\/conversions\/les-enfants-de-la-terre-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#a7503a&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Jean M. Auel&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;auel-jean-m&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/auel-jean-m&quot;
                    }
                }
            ],
            &quot;count&quot;: 6
        },
        {
            &quot;title&quot;: &quot;L'&Eacute;pouvanteur&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;lepouvanteur-fr&quot;,
                &quot;author&quot;: &quot;delaney-joseph&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/delaney-joseph\/lepouvanteur-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/delaney-joseph\/lepouvanteur-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1153\/conversions\/lepouvanteur-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1153\/conversions\/lepouvanteur-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#63371b&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Joseph Delaney&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;delaney-joseph&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/delaney-joseph&quot;
                    }
                }
            ],
            &quot;count&quot;: 13
        },
        {
            &quot;title&quot;: &quot;Ernaut de J&eacute;rusalem&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;ernaut-de-jerusalem-fr&quot;,
                &quot;author&quot;: &quot;kervran-yann&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/kervran-yann\/ernaut-de-jerusalem-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/kervran-yann\/ernaut-de-jerusalem-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1154\/conversions\/ernaut-de-jerusalem-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1154\/conversions\/ernaut-de-jerusalem-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#a2502e&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Yann Kervran&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;kervran-yann&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/kervran-yann&quot;
                    }
                }
            ],
            &quot;count&quot;: 1
        },
        {
            &quot;title&quot;: &quot;La Fille Dragon&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;la-fille-dragon-fr&quot;,
                &quot;author&quot;: &quot;troisi-licia&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/troisi-licia\/la-fille-dragon-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/troisi-licia\/la-fille-dragon-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1155\/conversions\/la-fille-dragon-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1155\/conversions\/la-fille-dragon-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#5f523f&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Licia Troisi&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;troisi-licia&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/troisi-licia&quot;
                    }
                }
            ],
            &quot;count&quot;: 5
        },
        {
            &quot;title&quot;: &quot;Fondation&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;fondation-fr&quot;,
                &quot;author&quot;: &quot;asimov-isaac&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/asimov-isaac\/fondation-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/asimov-isaac\/fondation-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1156\/conversions\/fondation-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1156\/conversions\/fondation-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#b1a996&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Isaac Asimov&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;asimov-isaac&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/asimov-isaac&quot;
                    }
                }
            ],
            &quot;count&quot;: 7
        },
        {
            &quot;title&quot;: &quot;Le Fou et l'Assassin&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;le-fou-et-lassassin-fr&quot;,
                &quot;author&quot;: &quot;hobb-robin&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/hobb-robin\/le-fou-et-lassassin-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/hobb-robin\/le-fou-et-lassassin-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1157\/conversions\/le-fou-et-lassassin-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1157\/conversions\/le-fou-et-lassassin-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#cfd0d5&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Robin Hobb&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;hobb-robin&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/hobb-robin&quot;
                    }
                }
            ],
            &quot;count&quot;: 6
        },
        {
            &quot;title&quot;: &quot;La fraternit&eacute; du Panca&quot;,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;la-fraternite-du-panca-fr&quot;,
                &quot;author&quot;: &quot;bordage-pierre&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/series\/bordage-pierre\/la-fraternite-du-panca-fr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/series\/books\/bordage-pierre\/la-fraternite-du-panca-fr&quot;
            },
            &quot;picture&quot;: {
                &quot;base&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1158\/conversions\/la-fraternite-du-panca-fr-thumbnail.webp&quot;,
                &quot;simple&quot;: &quot;http:\/\/localhost:8000\/storage\/media\/series\/1158\/conversions\/la-fraternite-du-panca-fr-simple.jpg&quot;,
                &quot;color&quot;: &quot;#645853&quot;
            },
            &quot;language&quot;: &quot;fr&quot;,
            &quot;authors&quot;: [
                {
                    &quot;name&quot;: &quot;Pierre Bordage&quot;,
                    &quot;meta&quot;: {
                        &quot;slug&quot;: &quot;bordage-pierre&quot;,
                        &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/authors\/bordage-pierre&quot;
                    }
                }
            ],
            &quot;count&quot;: 5
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http:\/\/localhost:8000\/api\/series?page=1&quot;,
        &quot;last&quot;: &quot;http:\/\/localhost:8000\/api\/series?page=3&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: &quot;http:\/\/localhost:8000\/api\/series?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 3,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/series?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/series?page=2&quot;,
                &quot;label&quot;: &quot;2&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/series?page=3&quot;,
                &quot;label&quot;: &quot;3&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http:\/\/localhost:8000\/api\/series?page=2&quot;,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http:\/\/localhost:8000\/api\/series&quot;,
        &quot;per_page&quot;: 32,
        &quot;to&quot;: 32,
        &quot;total&quot;: 80
    }
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-series" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-series"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-series"></code></pre>
            </span>
            <span id="execution-error-GETapi-series" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-series"></code></pre>
            </span>
            <form id="form-GETapi-series" data-method="GET" data-path="api/series" data-authed="0" data-hasfiles="0"
                data-isarraybody="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
                autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-series', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-series" onclick="tryItOut('GETapi-series');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-series" onclick="cancelTryOut('GETapi-series');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-series" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/series</code></b>
                </p>
            </form>

            <h2 id="serie-GETapi-series--author---serie-">GET api/series/{author}/{serie}</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-series--author---serie-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/series/nobis/similique" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/series/nobis/similique"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-series--author---serie-">
                <blockquote>
                    <p>Example response (404):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4995
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Author].&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
    &quot;line&quot;: 383,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
            &quot;line&quot;: 332,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/nunomaduro\/collision\/src\/Adapters\/Laravel\/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 130,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-series--author---serie-" hidden>
                <blockquote>Received response<span
                        id="execution-response-status-GETapi-series--author---serie-"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-series--author---serie-"></code></pre>
            </span>
            <span id="execution-error-GETapi-series--author---serie-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-series--author---serie-"></code></pre>
            </span>
            <form id="form-GETapi-series--author---serie-" data-method="GET" data-path="api/series/{author}/{serie}"
                data-authed="0" data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-series--author---serie-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-series--author---serie-"
                        onclick="tryItOut('GETapi-series--author---serie-');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-series--author---serie-"
                        onclick="cancelTryOut('GETapi-series--author---serie-');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-series--author---serie-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/series/{author}/{serie}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>author</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="author" data-endpoint="GETapi-series--author---serie-" data-component="url"
                        required hidden>
                    <br>
                </p>
                <p>
                    <b><code>serie</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="serie" data-endpoint="GETapi-series--author---serie-" data-component="url"
                        required hidden>
                    <br>
                </p>
            </form>

            <h2 id="serie-GETapi-series-books--author---serie-">GET api/series/books/{author}/{serie}</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-series-books--author---serie-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/series/books/13/laudantium" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/series/books/13/laudantium"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-series-books--author---serie-">
                <blockquote>
                    <p>Example response (404):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4994
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Author].&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
    &quot;line&quot;: 383,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
            &quot;line&quot;: 332,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/nunomaduro\/collision\/src\/Adapters\/Laravel\/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 130,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-series-books--author---serie-" hidden>
                <blockquote>Received response<span
                        id="execution-response-status-GETapi-series-books--author---serie-"></span>:
                </blockquote>
                <pre
                    class="json"><code id="execution-response-content-GETapi-series-books--author---serie-"></code></pre>
            </span>
            <span id="execution-error-GETapi-series-books--author---serie-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-series-books--author---serie-"></code></pre>
            </span>
            <form id="form-GETapi-series-books--author---serie-" data-method="GET"
                data-path="api/series/books/{author}/{serie}" data-authed="0" data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-series-books--author---serie-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-series-books--author---serie-"
                        onclick="tryItOut('GETapi-series-books--author---serie-');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-series-books--author---serie-"
                        onclick="cancelTryOut('GETapi-series-books--author---serie-');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-series-books--author---serie-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/series/books/{author}/{serie}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>author</code></b>&nbsp;&nbsp;<small>integer</small> &nbsp;
                    <input type="number" name="author" data-endpoint="GETapi-series-books--author---serie-"
                        data-component="url" required hidden>
                    <br>
                </p>
                <p>
                    <b><code>serie</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="serie" data-endpoint="GETapi-series-books--author---serie-"
                        data-component="url" required hidden>
                    <br>
                </p>
            </form>

            <h2 id="serie-GETapi-series-books--volume---author---serie-">GET api/series/books/{volume}/{author}/{serie}
            </h2>

            <p>
            </p>



            <span id="example-requests-GETapi-series-books--volume---author---serie-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/series/books/18/sunt/nemo" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/series/books/18/sunt/nemo"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-series-books--volume---author---serie-">
                <blockquote>
                    <p>Example response (404):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4993
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Author].&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
    &quot;line&quot;: 383,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Exceptions\/Handler.php&quot;,
            &quot;line&quot;: 332,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/nunomaduro\/collision\/src\/Adapters\/Laravel\/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 130,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-series-books--volume---author---serie-" hidden>
                <blockquote>Received response<span
                        id="execution-response-status-GETapi-series-books--volume---author---serie-"></span>:
                </blockquote>
                <pre
                    class="json"><code id="execution-response-content-GETapi-series-books--volume---author---serie-"></code></pre>
            </span>
            <span id="execution-error-GETapi-series-books--volume---author---serie-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-series-books--volume---author---serie-"></code></pre>
            </span>
            <form id="form-GETapi-series-books--volume---author---serie-" data-method="GET"
                data-path="api/series/books/{volume}/{author}/{serie}" data-authed="0" data-hasfiles="0"
                data-isarraybody="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
                autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-series-books--volume---author---serie-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-series-books--volume---author---serie-"
                        onclick="tryItOut('GETapi-series-books--volume---author---serie-');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-series-books--volume---author---serie-"
                        onclick="cancelTryOut('GETapi-series-books--volume---author---serie-');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-series-books--volume---author---serie-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/series/books/{volume}/{author}/{serie}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>volume</code></b>&nbsp;&nbsp;<small>integer</small> &nbsp;
                    <input type="number" name="volume" data-endpoint="GETapi-series-books--volume---author---serie-"
                        data-component="url" required hidden>
                    <br>
                </p>
                <p>
                    <b><code>author</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="author" data-endpoint="GETapi-series-books--volume---author---serie-"
                        data-component="url" required hidden>
                    <br>
                </p>
                <p>
                    <b><code>serie</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="serie" data-endpoint="GETapi-series-books--volume---author---serie-"
                        data-component="url" required hidden>
                    <br>
                </p>
            </form>

            <h1 id="tag">Tag</h1>



            <h2 id="tag-GETapi-tags">GET api/tags</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-tags">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/tags" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/tags"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-tags">
                <blockquote>
                    <p>Example response (200):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4977
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;name&quot;: &quot;A_lire&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;a-lire&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/a-lire&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/a-lire&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Adolescents&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;adolescents&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/adolescents&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/adolescents&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Adoptees&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;adoptees&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/adoptees&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/adoptees&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Ages 9 12 fiction&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;ages-9-12-fiction&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/ages-9-12-fiction&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/ages-9-12-fiction&quot;
            }
        },
        {
            &quot;name&quot;: &quot;All ages&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;all-ages&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/all-ages&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/all-ages&quot;
            }
        },
        {
            &quot;name&quot;: &quot;American&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;american&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/american&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/american&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Amour&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 8,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;amour&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/amour&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/amour&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Amour fraternel&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;amour-fraternel&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/amour-fraternel&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/amour-fraternel&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Animals&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;animals&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/animals&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/animals&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Anneau&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;anneau&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/anneau&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/anneau&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Anthology&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;anthology&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/anthology&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/anthology&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Anticipation&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;anticipation&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/anticipation&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/anticipation&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Aventure&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;aventure&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/aventure&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/aventure&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Bilingual education&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;bilingual-education&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/bilingual-education&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/bilingual-education&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Bit lit&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 12,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;bit-lit&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/bit-lit&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/bit-lit&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Cats&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;cats&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/cats&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/cats&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Children: grades 4 6&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;children-grades-4-6&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/children-grades-4-6&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/children-grades-4-6&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Children's books&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;childrens-books&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/childrens-books&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/childrens-books&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Classics&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 5,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;classics&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/classics&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/classics&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Clean &amp; wholesome&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;clean-wholesome&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/clean-wholesome&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/clean-wholesome&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Coming of age&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;coming-of-age&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/coming-of-age&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/coming-of-age&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Coming out&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;coming-out&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/coming-out&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/coming-out&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Contemporains&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;contemporains&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/contemporains&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/contemporains&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Contemporary&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 11,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;contemporary&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/contemporary&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/contemporary&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Cousins&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;cousins&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/cousins&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/cousins&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Death &amp; dying&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;death-dying&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/death-dying&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/death-dying&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Demonology&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;demonology&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/demonology&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/demonology&quot;
            }
        },
        {
            &quot;name&quot;: &quot;D&eacute;mons&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;demons&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/demons&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/demons&quot;
            }
        },
        {
            &quot;name&quot;: &quot;D&egrave;s 12 ans&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;des-12-ans&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/des-12-ans&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/des-12-ans&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Deuil&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;deuil&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/deuil&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/deuil&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Djinn&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;djinn&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/djinn&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/djinn&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Domestic drama&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;domestic-drama&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/domestic-drama&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/domestic-drama&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Dragons&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;dragons&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/dragons&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/dragons&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Drama&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;drama&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/drama&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/drama&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Drena&iuml;&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 10,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;drenai&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/drenai&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/drenai&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Education&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;education&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/education&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/education&quot;
            }
        },
        {
            &quot;name&quot;: &quot;England&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;england&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/england&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/england&quot;
            }
        },
        {
            &quot;name&quot;: &quot;English&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;english&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/english&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/english&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Epic&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 32,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;epic&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/epic&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/epic&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Epouvanteur&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;epouvanteur&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/epouvanteur&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/epouvanteur&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Ernaut de j&eacute;rusalem&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;ernaut-de-jerusalem&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/ernaut-de-jerusalem&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/ernaut-de-jerusalem&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Espoir&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;espoir&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/espoir&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/espoir&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Europe&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;europe&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/europe&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/europe&quot;
            }
        },
        {
            &quot;name&quot;: &quot;European&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;european&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/european&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/european&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Ewilan&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;ewilan&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/ewilan&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/ewilan&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Family&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;family&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/family&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/family&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Fantastique&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 47,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;fantastique&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/fantastique&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/fantastique&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Fantastique   horreur&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;fantastique-horreur&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/fantastique-horreur&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/fantastique-horreur&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Fantastique &amp; sf&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;fantastique-sf&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/fantastique-sf&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/fantastique-sf&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Fantasy fiction&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;fantasy-fiction&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/fantasy-fiction&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/fantasy-fiction&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Fantasy &amp; magic&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 12,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;fantasy-magic&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/fantasy-magic&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/fantasy-magic&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Fiction&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 144,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;fiction&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/fiction&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/fiction&quot;
            }
        },
        {
            &quot;name&quot;: &quot;First loves&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;first-loves&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/first-loves&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/first-loves&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Fna&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;fna&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/fna&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/fna&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Foreign language study&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;foreign-language-study&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/foreign-language-study&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/foreign-language-study&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Friendship&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;friendship&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/friendship&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/friendship&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Gay&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;gay&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/gay&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/gay&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Gay love&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;gay-love&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/gay-love&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/gay-love&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Gay romance&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 5,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;gay-romance&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/gay-romance&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/gay-romance&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Gay sex&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;gay-sex&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/gay-sex&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/gay-sex&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Golem&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;golem&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/golem&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/golem&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Hexagora&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;hexagora&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/hexagora&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/hexagora&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Historical&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 3,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;historical&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/historical&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/historical&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Historique&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 4,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;historique&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/historique&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/historique&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Homosexual&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;homosexual&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/homosexual&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/homosexual&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Horreur&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;horreur&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/horreur&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/horreur&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Horror fiction&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;horror-fiction&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/horror-fiction&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/horror-fiction&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Humour&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;humour&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/humour&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/humour&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Ince&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;ince&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/ince&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/ince&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Inheritance &amp; succession&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;inheritance-succession&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/inheritance-succession&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/inheritance-succession&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Irish&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;irish&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/irish&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/irish&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Italian&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;italian&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/italian&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/italian&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Jeunesse&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 49,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;jeunesse&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/jeunesse&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/jeunesse&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Jeunesse fantasy&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;jeunesse-fantasy&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/jeunesse-fantasy&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/jeunesse-fantasy&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Juvenile fiction&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 33,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;juvenile-fiction&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/juvenile-fiction&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/juvenile-fiction&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Lang:fr&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;langfr&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/langfr&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/langfr&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Language&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;language&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/language&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/language&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Le prince des t&eacute;n&egrave;bres&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;le-prince-des-tenebres&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/le-prince-des-tenebres&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/le-prince-des-tenebres&quot;
            }
        },
        {
            &quot;name&quot;: &quot;L'&Eacute;pouvanteur&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;lepouvanteur&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/lepouvanteur&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/lepouvanteur&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Les mondes d'ewilan&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;les-mondes-dewilan&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/les-mondes-dewilan&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/les-mondes-dewilan&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Lgbt&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;lgbt&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/lgbt&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/lgbt&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Lgbt fiction&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;lgbt-fiction&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/lgbt-fiction&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/lgbt-fiction&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Lgbt romance&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;lgbt-romance&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/lgbt-romance&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/lgbt-romance&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Lgbt youth&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;lgbt-youth&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/lgbt-youth&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/lgbt-youth&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Literary&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 5,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;literary&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/literary&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/literary&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Literary criticism&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;literary-criticism&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/literary-criticism&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/literary-criticism&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Litt&eacute;rature anglaise&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;litterature-anglaise&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/litterature-anglaise&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/litterature-anglaise&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Litt&eacute;rature fran&ccedil;aise&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;litterature-francaise&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/litterature-francaise&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/litterature-francaise&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Love&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;love&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/love&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/love&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Love &amp; romance&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;love-romance&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/love-romance&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/love-romance&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Love stories&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;love-stories&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/love-stories&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/love-stories&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Lu&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;lu&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/lu&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/lu&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Magiciens&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;magiciens&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/magiciens&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/magiciens&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Magie&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;magie&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/magie&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/magie&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Magie noire&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;magie-noire&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/magie-noire&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/magie-noire&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Man woman relationships&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;man-woman-relationships&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/man-woman-relationships&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/man-woman-relationships&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Mass murderers&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;mass-murderers&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/mass-murderers&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/mass-murderers&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Mm&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;mm&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/mm&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/mm&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Mm romance&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;mm-romance&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/mm-romance&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/mm-romance&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Moyen orient&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;moyen-orient&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/moyen-orient&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/moyen-orient&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Mystery &amp; detective&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;mystery-detective&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/mystery-detective&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/mystery-detective&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Non lu&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;non-lu&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/non-lu&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/non-lu&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Nouvelles&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 3,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;nouvelles&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/nouvelles&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/nouvelles&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Nouvellles&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;nouvellles&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/nouvellles&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/nouvellles&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Occult fiction&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;occult-fiction&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/occult-fiction&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/occult-fiction&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Occult &amp; supernatural&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;occult-supernatural&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/occult-supernatural&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/occult-supernatural&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Ontario&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;ontario&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/ontario&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/ontario&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Paranormal&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 9,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;paranormal&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/paranormal&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/paranormal&quot;
            }
        },
        {
            &quot;name&quot;: &quot;People &amp; places&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;people-places&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/people-places&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/people-places&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Phrase books&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;phrase-books&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/phrase-books&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/phrase-books&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Po&eacute;sie&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;poesie&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/poesie&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/poesie&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Police   ontario   toronto&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;police-ontario-toronto&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/police-ontario-toronto&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/police-ontario-toronto&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Policier&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 6,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;policier&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/policier&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/policier&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Post apocalyptique&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 6,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;post-apocalyptique&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/post-apocalyptique&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/post-apocalyptique&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Pouvoirs&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;pouvoirs&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/pouvoirs&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/pouvoirs&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Psychologie&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;psychologie&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/psychologie&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/psychologie&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Queer fiction&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;queer-fiction&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/queer-fiction&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/queer-fiction&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Rejection (psychology)&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;rejection-psychology&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/rejection-psychology&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/rejection-psychology&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Relationships&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;relationships&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/relationships&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/relationships&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Roman&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;roman&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/roman&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/roman&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Roman historique&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 6,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;roman-historique&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/roman-historique&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/roman-historique&quot;
            }
        },
        {
            &quot;name&quot;: &quot;San francisco (calif.)&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;san-francisco-calif&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/san-francisco-calif&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/san-francisco-calif&quot;
            }
        },
        {
            &quot;name&quot;: &quot;School &amp; education&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;school-education&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/school-education&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/school-education&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Scottish&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;scottish&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/scottish&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/scottish&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Sexuality&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;sexuality&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/sexuality&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/sexuality&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Ship captains&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;ship-captains&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/ship-captains&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/ship-captains&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Short stories&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;short-stories&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/short-stories&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/short-stories&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Siblings&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;siblings&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/siblings&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/siblings&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Sisters&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;sisters&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/sisters&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/sisters&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Social classes&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;social-classes&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/social-classes&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/social-classes&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Social science&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;social-science&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/social-science&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/social-science&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Social themes&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;social-themes&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/social-themes&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/social-themes&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Something like summer&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;something-like-summer&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/something-like-summer&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/something-like-summer&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Space opera&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 14,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;space-opera&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/space-opera&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/space-opera&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Steampunk&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;steampunk&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/steampunk&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/steampunk&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Supernatural&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;supernatural&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/supernatural&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/supernatural&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Tasteful&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;tasteful&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/tasteful&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/tasteful&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Terreur&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;terreur&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/terreur&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/terreur&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Texas&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;texas&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/texas&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/texas&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Th&eacute;&acirc;tre&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;theatre&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/theatre&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/theatre&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Toronto&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;toronto&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/toronto&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/toronto&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Toronto (ont.)&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;toronto-ont&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/toronto-ont&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/toronto-ont&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Tour b2  &quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;tour-b2&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/tour-b2&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/tour-b2&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Trilogie&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;trilogie&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/trilogie&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/trilogie&quot;
            }
        },
        {
            &quot;name&quot;: &quot;United states&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;united-states&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/united-states&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/united-states&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Urban&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;urban&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/urban&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/urban&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Vampire&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 8,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;vampire&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/vampire&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/vampire&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Vampires&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;vampires&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/vampires&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/vampires&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Vampires   ontario   toronto&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;vampires-ontario-toronto&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/vampires-ontario-toronto&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/vampires-ontario-toronto&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Welsh&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;welsh&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/welsh&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/welsh&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Women private investigators&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;women-private-investigators&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/women-private-investigators&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/women-private-investigators&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Young adult&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 2,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;young-adult&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/young-adult&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/young-adult&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Young adult fiction&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 4,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;young-adult-fiction&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/young-adult-fiction&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/young-adult-fiction&quot;
            }
        },
        {
            &quot;name&quot;: &quot;Young women&quot;,
            &quot;type&quot;: &quot;tag&quot;,
            &quot;count&quot;: 1,
            &quot;meta&quot;: {
                &quot;slug&quot;: &quot;young-women&quot;,
                &quot;books&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/books\/young-women&quot;,
                &quot;show&quot;: &quot;http:\/\/localhost:8000\/api\/tags\/young-women&quot;
            }
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-tags" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-tags"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-tags"></code></pre>
            </span>
            <span id="execution-error-GETapi-tags" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-tags"></code></pre>
            </span>
            <form id="form-GETapi-tags" data-method="GET" data-path="api/tags" data-authed="0" data-hasfiles="0"
                data-isarraybody="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
                autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-tags', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-tags" onclick="tryItOut('GETapi-tags');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-tags" onclick="cancelTryOut('GETapi-tags');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-tags" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/tags</code></b>
                </p>
            </form>

            <h2 id="tag-GETapi-tags--id-">GET api/tags/{id}</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-tags--id-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/tags/rerum" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/tags/rerum"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-tags--id-">
                <blockquote>
                    <p>Example response (500):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4976
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;Attempt to read property \&quot;books_count\&quot; on null&quot;,
    &quot;exception&quot;: &quot;ErrorException&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/app\/Http\/Resources\/Tag\/TagLightResource.php&quot;,
    &quot;line&quot;: 26,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/app\/Http\/Resources\/Tag\/TagLightResource.php&quot;,
            &quot;line&quot;: 26,
            &quot;function&quot;: &quot;handleError&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Bootstrap\\HandleExceptions&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/app\/Http\/Resources\/Tag\/TagResource.php&quot;,
            &quot;line&quot;: 22,
            &quot;function&quot;: &quot;toArray&quot;,
            &quot;class&quot;: &quot;App\\Http\\Resources\\Tag\\TagLightResource&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Http\/Resources\/Json\/JsonResource.php&quot;,
            &quot;line&quot;: 96,
            &quot;function&quot;: &quot;toArray&quot;,
            &quot;class&quot;: &quot;App\\Http\\Resources\\Tag\\TagResource&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Http\/Resources\/Json\/ResourceResponse.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;resolve&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Resources\\Json\\JsonResource&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Http\/Resources\/Json\/JsonResource.php&quot;,
            &quot;line&quot;: 222,
            &quot;function&quot;: &quot;toResponse&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Resources\\Json\\ResourceResponse&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 776,
            &quot;function&quot;: &quot;toResponse&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Resources\\Json\\JsonResource&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 763,
            &quot;function&quot;: &quot;toResponse&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 695,
            &quot;function&quot;: &quot;prepareResponse&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Routing\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-tags--id-" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-tags--id-"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-tags--id-"></code></pre>
            </span>
            <span id="execution-error-GETapi-tags--id-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-tags--id-"></code></pre>
            </span>
            <form id="form-GETapi-tags--id-" data-method="GET" data-path="api/tags/{id}" data-authed="0"
                data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-tags--id-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-tags--id-" onclick="tryItOut('GETapi-tags--id-');">Try it out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-tags--id-" onclick="cancelTryOut('GETapi-tags--id-');" hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-tags--id-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/tags/{id}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>id</code></b>&nbsp;&nbsp;<small>string</small> &nbsp;
                    <input type="text" name="id" data-endpoint="GETapi-tags--id-" data-component="url" required hidden>
                    <br>
                <p>The ID of the tag.</p>
                </p>
            </form>

            <h2 id="tag-GETapi-tags-books--tag-">GET api/tags/books/{tag}</h2>

            <p>
            </p>



            <span id="example-requests-GETapi-tags-books--tag-">
                <blockquote>Example request:</blockquote>


                <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/tags/books/18" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

                <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/tags/books/18"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
            </span>

            <span id="example-responses-GETapi-tags-books--tag-">
                <blockquote>
                    <p>Example response (500):</p>
                </blockquote>
                <details class="annotation">
                    <summary>
                        <small
                            onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show
                            headers</small>
                    </summary>
                    <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 5000
x-ratelimit-remaining: 4975
vary: Origin
 </code></pre>
                </details>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;Spatie\\Tags\\Tag::findFromString(): Argument #1 ($name) must be of type string, null given, called in \/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/spatie\/laravel-tags\/src\/HasTags.php on line 201&quot;,
    &quot;exception&quot;: &quot;TypeError&quot;,
    &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/spatie\/laravel-tags\/src\/Tag.php&quot;,
    &quot;line&quot;: 63,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/spatie\/laravel-tags\/src\/HasTags.php&quot;,
            &quot;line&quot;: 201,
            &quot;function&quot;: &quot;findFromString&quot;,
            &quot;class&quot;: &quot;Spatie\\Tags\\Tag&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;function&quot;: &quot;Spatie\\Tags\\{closure}&quot;,
            &quot;class&quot;: &quot;App\\Models\\Book&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Collections\/Collection.php&quot;,
            &quot;line&quot;: 642,
            &quot;function&quot;: &quot;array_map&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/spatie\/laravel-tags\/src\/HasTags.php&quot;,
            &quot;line&quot;: 202,
            &quot;function&quot;: &quot;map&quot;,
            &quot;class&quot;: &quot;Illuminate\\Support\\Collection&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/spatie\/laravel-tags\/src\/HasTags.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;convertToTags&quot;,
            &quot;class&quot;: &quot;App\\Models\\Book&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Model.php&quot;,
            &quot;line&quot;: 1400,
            &quot;function&quot;: &quot;scopeWithAllTags&quot;,
            &quot;class&quot;: &quot;App\\Models\\Book&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Builder.php&quot;,
            &quot;line&quot;: 1193,
            &quot;function&quot;: &quot;callNamedScope&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Builder.php&quot;,
            &quot;line&quot;: 1174,
            &quot;function&quot;: &quot;Illuminate\\Database\\Eloquent\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Builder.php&quot;,
            &quot;line&quot;: 1192,
            &quot;function&quot;: &quot;callScope&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Builder.php&quot;,
            &quot;line&quot;: 1613,
            &quot;function&quot;: &quot;callNamedScope&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Support\/Traits\/ForwardsCalls.php&quot;,
            &quot;line&quot;: 23,
            &quot;function&quot;: &quot;__call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Builder&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Model.php&quot;,
            &quot;line&quot;: 2000,
            &quot;function&quot;: &quot;forwardCallTo&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Database\/Eloquent\/Model.php&quot;,
            &quot;line&quot;: 2012,
            &quot;function&quot;: &quot;__call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/app\/Http\/Controllers\/Api\/TagController.php&quot;,
            &quot;line&quot;: 46,
            &quot;function&quot;: &quot;__callStatic&quot;,
            &quot;class&quot;: &quot;Illuminate\\Database\\Eloquent\\Model&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;books&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\Api\\TagController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;callAction&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Controller&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php&quot;,
            &quot;line&quot;: 254,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\ControllerDispatcher&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php&quot;,
            &quot;line&quot;: 197,
            &quot;function&quot;: &quot;runController&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 695,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Routing\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 127,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php&quot;,
            &quot;line&quot;: 55,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 33,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\{closure}&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 697,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 672,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 636,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php&quot;,
            &quot;line&quot;: 625,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 128,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php&quot;,
            &quot;line&quot;: 52,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fruitcake\\Cors\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/fideloper\/proxy\/src\/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php&quot;,
            &quot;line&quot;: 103,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php&quot;,
            &quot;line&quot;: 110,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 275,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 44,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php&quot;,
            &quot;line&quot;: 34,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 225,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Extractor.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 118,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 75,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/GroupedEndpoints\/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 136,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Command\/Command.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php&quot;,
            &quot;line&quot;: 121,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 978,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 295,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/symfony\/console\/Application.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;\/mnt\/c\/workspace\/projets\/bookshelves-back\/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
            </span>
            <span id="execution-results-GETapi-tags-books--tag-" hidden>
                <blockquote>Received response<span id="execution-response-status-GETapi-tags-books--tag-"></span>:
                </blockquote>
                <pre class="json"><code id="execution-response-content-GETapi-tags-books--tag-"></code></pre>
            </span>
            <span id="execution-error-GETapi-tags-books--tag-" hidden>
                <blockquote>Request failed with error:</blockquote>
                <pre><code id="execution-error-message-GETapi-tags-books--tag-"></code></pre>
            </span>
            <form id="form-GETapi-tags-books--tag-" data-method="GET" data-path="api/tags/books/{tag}" data-authed="0"
                data-hasfiles="0" data-isarraybody="0"
                data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' autocomplete="off"
                onsubmit="event.preventDefault(); executeTryOut('GETapi-tags-books--tag-', this);">
                <h3>
                    Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                        style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-tryout-GETapi-tags-books--tag-" onclick="tryItOut('GETapi-tags-books--tag-');">Try it
                        out ⚡
                    </button>
                    <button type="button"
                        style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-canceltryout-GETapi-tags-books--tag-" onclick="cancelTryOut('GETapi-tags-books--tag-');"
                        hidden>Cancel
                    </button>&nbsp;&nbsp;
                    <button type="submit"
                        style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                        id="btn-executetryout-GETapi-tags-books--tag-" hidden>Send Request 💥
                    </button>
                </h3>
                <p>
                    <small class="badge badge-green">GET</small>
                    <b><code>api/tags/books/{tag}</code></b>
                </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                <p>
                    <b><code>tag</code></b>&nbsp;&nbsp;<small>integer</small> &nbsp;
                    <input type="number" name="tag" data-endpoint="GETapi-tags-books--tag-" data-component="url"
                        required hidden>
                    <br>
                </p>
            </form>




        </div>
        <div class="dark-box">
            <div class="lang-selector">
                <a href="#" data-language-name="bash">bash</a>
                <a href="#" data-language-name="javascript">javascript</a>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            var exampleLanguages = ["bash", "javascript"];
            setupLanguages(exampleLanguages);
        });
    </script>
</body>

</html>
