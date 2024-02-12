<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>
<body>
    {{-- <div class="container">
        <a href="{{route('/')}}">Back</a>
    </div> --}}
    <div class="container text-center p-5 d-flex justify-content-center">
        <div class="row">
            <div class="col-12">
                <div class="card p-3">
                    <h2>Convert chat completions</h2>
                    <form action="{{ route('store.completions') }}" method="post">
                        @csrf
                        <label for="">Text</label>
                        <textarea name="text" class="form-control mt-3" cols="50" rows="10">{{$body}}</textarea>
                        <button class="btn btn-primary mt-3">Operative Note</button>
                    </form>
                    <div class="mt-3" id="output"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        function convertToJson() {
            var jsonInput = document.getElementById('jsonInput').value;
            console.log(jsonInput);
            try {
                var jsonObject = JSON.parse(jsonInput);
                var jsonString = JSON.stringify(jsonObject, null, 2);
                document.getElementById('output').innerText = jsonString;

                // Convert text to PDF
                var pdf = new jsPDF();
                pdf.text(jsonString, 10, 10);
                pdf.save('converted.pdf');
            } catch (error) {
                document.getElementById('output').innerText = 'Invalid JSON input';
            }
        }
    </script> --}}
</body>
</html>
