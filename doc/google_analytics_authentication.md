## Get your credentials

Application is using `widop/google-analytics` library which allows you to request the google analytics service without user interaction.
In order to make it possible, you need to create a Google Service Account. Here, the explanation:

 * Create a [Google App](http://code.google.com/apis/console).
 * Enable the Google Analytics service.
 * Create a service account on [Google App](http://code.google.com/apis/console) (Tab "API Access", choose
   "Create client ID" and then "Service account").
 * You should have received the `client_id` and `profile_id` in a email from Google but if you don't, then:
   * Check the "API Access" tab of your [Google App](http://code.google.com/apis/console) to get your client_id (use "Email Adress")
   * Check the [Google Analytics](http://www.google.com/analytics) admin panel (Sign in -> Admin -> Profile column ->
     Settings -> View ID) for the profile_id (don't forget to prefix the view ID by ga:)
   * Add access to your Google Analytics Profile (Sign in -> Admin -> Profile column ->
     Users Management) for your client_id (email address from previous step).
 * Download the private key and put it somewhere in: `bin/ga_p12_key/`. Change private key file name to `certificate.p12`.

At the end, you should have:

 * `client_id`: an email address which should look like `XXXXXXXXXXXX@developer.gserviceaccount.com`.
 * `profile_id`: a view ID which should look like `ga:XXXXXXXX`.
 * `private_key`: a PKCS12 certificate file

Use those data to fill `parameters.yml` settings:

```
ga_client_id => client_id
ga_profile_id => profile_id
```
