How to run:

```bash
php artisan migrate
php artisan serve
php artisan queue:work
```

API endpoints:

```bash
GET /api/employee
GET /api/employee/{id}
DELETE /api/employee/{id}
POST /api/employee
```

I used Job Queue to import large dataset from csv file and it is because it would take much time for importing all datasets.

To use job queue, I need to validate the correct file and column names as well as the correct data type of each cells.

After passing all the validation, the file is sent to the job queue and return success response.

And also I think your import.csv file doesn't have valid data tyeps for each column, so I used another test.csv file instead of it.

I hope this works well.

Thank you.
