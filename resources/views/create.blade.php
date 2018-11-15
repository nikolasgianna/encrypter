<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Create Form<h1>

    <form method="post" action="/create">

      {{ csrf_field() }}

      <div>
        <input type="text" name="title" placeholder="Title of link">
      </div>

      <div>
        <textarea name="description" placeholder="Links Form"></textarea>
      </div>

      <div>
        <input type='text' name="url" placeholder="URL">
      </div>

      <div>
        <button type="submit">Upload Links</button>
      </div>

    </form>
  </body>
</html>
