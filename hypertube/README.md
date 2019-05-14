# hypertube

### synopsis
Ce projet vous propose de créer une application web permettant à un utilisateur de
rechercher et visionner des vidéos.
Le lecteur sera directement intégré au site, et les vidéos seront téléchargées au travers
du protocole BitTorrent.

### technologies we'll use
> **[Node.js](https://nodejs.org/)**<br>
> **[React](https://reactjs.org/)**<br>
> **[MySQL](https://www.mysql.com/)**<br>
> we'll keep our old Matha API and wrapped functions for mysql calls

### important habits
- [x] find APIs that we will have to call for getting the films
- [x] implement a function library to call our API from the front-end
- [x] read docs about Omniauth
- [ ] read docs about bitTorrent file streaming
- [ ] read docs about displaying different languages (eventually with google traduction's API)
- [ ] read docs about subtitles

### differents pages
> **front-end routes/pages**
```
/
```
```
/sign/in
/sign/up
/sign/out
```
```
/profile
/profile/:id
/settings
```
```
/account/confirm
/account/reset_password
```
```
/library
```
```
/v/:id
```

### apis
https://popcorntime.api-docs.io/api/welcome/introduction<br>
https://yts.am/api<br>
https://www.themoviedb.org/documentation/api (to get more data on movies)<br>
http://www.legittorrents.info/index.php?page=torrents&category=1<br>

https://webtorrent.io/docs<br>
https://github.com/davidgatti/How-to-Stream-Movies-using-NodeJS
