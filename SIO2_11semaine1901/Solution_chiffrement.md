# SSH

## Client side (SSH server):
Switch to password yes and comment publickeyauthentication before using ssh-copy-id in Server side
Clear authorized_keys as well if permission denied because of old keys
sudo nano /etc/ssh/sshd_config
sudo service sshd restart

## Server side:
Clear known_hosts as well if permission denied because of old keys
ssh-keygen -> keep default key (id_25519)
ssh-copy-id -i ~/.ssh/station_essence.pub osboxes@192.168.56.104
ssh osboxes@192.168.56.104
If scuccessful, switch to password no and uncomment publickeyauthentication
exit then try again should be no password and success login

## A good description here:

"What you're missing is that ssh-copy-id doesn't just copy the public key to B: it adds the public key to the list of keys that allow access to the account (~/.ssh/authorized_keys). After running ssh-copy-id, the key is not just stored on B somewhere, it's registered on B as an authorized login method.

The private key is on A, and needs to be passed to the SSH client (this can be done by letting it search ~/.ssh/id_*, by passing a -i command line option, by using IdentityFile in ~/.ssh/config, or via ssh-agent). The public key is in ~/.ssh/authorized_keys on B. When you log into B from A, the SSH client sends a proof of possession of the private key to B; B links this proof of possession with a public key found in ~/.ssh/authorized_keys so it authorizes the login attempt."

I found here:
https://unix.stackexchange.com/questions/279923/how-to-understand-ssh-keygen-and-ssh-copy-id

I just disagree on the first mention of "SSH client". It should be "SSH server" or the "host".


# GPG

## GPG server:
gpg --full-generate-key
gpg --export -a "your_email@example.com" > server-public-key.asc
sftp osboxes@192.168.56.105

## GPG client:
gpg --import server-public-key.asc
gpg --always-trust --output $BACKUP_DIR/$DB_NAME-$DATE.sql.gpg --encrypt --recipient $GPG_KEY $BACKUP_DIR/$DB_NAME-$DATE.sql

## GPG server:
gpg --output laravel-2025-01-27.sql --decrypt laravel-2025-01-27.sql.gpg 
