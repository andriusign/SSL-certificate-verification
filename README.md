# Verify SSL certificates

This is a simple app to verify that .CSR, .KEY and generated .CRT all match.
It will ensure that your generated .CRT has been issued using your generated .CSR.
If hashes match, everything is okay, if they don't, you should verify and/or request new .CRT file.

## Start PHP server locally

    php -S localhost:8888

## Verify SSL .CSR, .KEY, .CRT

open browser and navigate to <http://localhost:8888>

## Create certificates manually (locally)

Create CSR:
> openssl req -new > filename.csr

Create KEY
> openssl rsa -in privkey.pem -out filename.key

Create CERT
> openssl x509 -in filename.csr -out filename.cert -req -signkey filename.key -days 365

## Check certificate hashes (match = related) (manual)

Step 1:
> openssl pkey -in filename.key -pubout -outform pem | sha256sum

Step 2:
> openssl x509 -in filename.crt -pubkey -noout -outform pem | sha256sum

Step 3:
> openssl req -in filename.csr -pubkey -noout -outform pem | sha256sum

## Testing

You can check sample certificates in `certs` folder.

## More

You can use or modify this code freely without any restrictions. Any comments and improvements welcome.
