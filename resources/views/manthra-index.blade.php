<h2>Manthra</h2>

<form action="{{ route('generate-manthra') }}" method="POST">
     @csrf
     <div>
          <label>Model Name *</label>
          <input type="text" name="model_name" placeholder="eg: Post">
     </div> <br>

     <div>
          <label for="">Fields *</label>
          <input type="text" name="field_name[]" placeholder="Name">
          <input type="text" name="field_type[]" placeholder="Type">
     </div> <br>

     <div>
          <label>Controller Namespace</label>
          <input type="text" name="controller_namespace" placeholder="eg: Admin">
     </div> <br>

     <div>
          <label>Model Namespace</label>
          <input type="text" name="model_namespace" placeholder="eg: Models">
     </div> <br>

     <div>
          <label>View Path</label>
          <input type="text" name="model_namespace" placeholder="eg: admin">
     </div> <br>

     <div>
          <label>Route Group</label>
          <input type="text" name="route_group" placeholder="eg: admin">
     </div> <br>

     <button type="submit">Generate</button>
</form>