var scribe = require('scribe-js')(),
    app = require('express')(),
    server = require('http').Server(app),
    io = require('socket.io', { rememberTransport: false, transports: ['WebSocket', 'Flash Socket', 'AJAX long-polling'] })(server),
    requestify = require('requestify');

server.listen(2020);

  io.sockets.on('connection', function (socket) {
       updateStatus();
       socket.on('faka', function (data) {
         jet();
       });
            socket.on('updateBalance', function (data) {
         requestify.post('http://localhost/api/getBalance', {
           user: data.user
         })
             .then(function (response) {
                 data2 = JSON.parse(response.body);
                 io.sockets.emit('updateBalance2', {user2: data.user, balance: data2.balance});
                 updateStatus();
                        jet();
             }, function (err) {
               console.log(err);
             });

       });

      //  socket.on('big2', function (data) {
      //    getBig();
      //  });

       socket.on('newbet', function (data) {
         requestify.post('http://localhost/api/generateGame', {
           mode: data.mode,
           bet: data.bet,
           user: data.user
         })
             .then(function (response) {
                 data2 = JSON.parse(response.body);
                 updateStatus();
                 console.log("aaaaaaa");
                 if(data2.status == 'true'){
                   if(data2.banka == 1){
                      io.sockets.emit('newbet2', { banka: 1, user: data.user, start: 1, denied_attempt: 0, hash: data2.hash, seed: data2.number,seed2: data2.seed_c,seed3: data2.seed_u, mode: data.mode});
                   }else{
                      io.sockets.emit('newbet2', { banka: 0, user: data.user, start: 1, denied_attempt: 0, hash: data2.hash, seed: data2.number,seed2: data2.seed_c,seed3: data2.seed_u, mode: data.mode});
                   }
                 }else{
                   io.sockets.emit('balanceerror', {user: data.user, error: data2.error});
                   console.log("Balance error "+"User: " + data.user);
                 }
             }, function (err) {
               console.log(err);
             });
       });
       socket.on('takemoney', function(data){
         console.log("Take bet!");
           requestify.post('http://localhost/api/takebet', {
             user: data.user
           })
               .then(function (response) {
                   data2 = JSON.parse(response.body);
                        jet();
                   if(data2.status == 'true'){
                     if(data2.banka == 1){
                       socket.emit('takemoney2',  {banka: 1,user: data.user, status: 'true', error: data2.error, mode: data2.mode, fields_seed: data2.fields_seeds});
                     }else{
                        socket.emit('takemoney2',  {banka: 0,user: data.user, status: 'true', error: data2.error, mode: data2.mode, fields_seed: data2.fields_seeds});
                     }
                   }else{
                      if(data2.banka == 1){
                        socket.emit('takemoney2',  {banka: 1,user: data.user, status: 'false', error: data2.error,mode: data2.mode,fields_seed: data2.fields_seeds});
                      }else{
                         socket.emit('takemoney2',  {banka: 0,user: data.user, status: 'false', error: data2.error,mode: data2.mode,fields_seed: data2.fields_seeds});
                      }
                   }
               }, function (err) {
                 console.log(err);
               });
         });
         socket.on('setbet', function(data){
           updateStatus();
             requestify.post('http://localhost/api/checkGame', {
               level: data.level,
               pleyers: data.user,
               place: data.place
             })
                 .then(function (response) {
                     data2 = JSON.parse(response.body);
                     if(data2.status == 2){
                       socket.emit('setbet2',  {banka: data2.banka ,user: data.user,fields_seed: data2.fields_seeds, mode: data2.mode, status: data2.status, end_game: data2.end, game_bet_take: 1 , new_level: data2.level });
                     }else{
                       socket.emit('setbet2',  {banka: data2.banka ,user: data.user, mode: data2.mode, status: data2.status, end_game: data2.end, game_bet_take: 1 , new_level: data2.level });
                     }
                 }, function (err) {
                   console.log(err);
                 });
           });

      socket.on('newjoin', function (data) {
        io.sockets.emit('newgamejoin', {joinid2: data});
      });
      socket.on('delete', function (data) {
        io.sockets.emit('newdelete', {joinid2: data.deleteid});
      });

      socket.on('disconnect', function () {
          updateStatus();
      });

  });

function getBig(){
  requestify.post('http://localhost/api/getBig', {})
        .then(function (response) {
            data = JSON.parse(response.body);
            io.sockets.emit('big', data);
        }, function (err) {
          console.log(err);
        });
}

function updateTop() {
  requestify.post('http://localhost/api/getTopUser', {})
        .then(function (response) {
            data = JSON.parse(response.body);
            io.sockets.emit('top', data);
        }, function (err) {
          console.log(err);
        });
}
function getTopUserWeg() {
  requestify.post('http://localhost/api/getTopUserWeg', {})
        .then(function (response) {
            data = JSON.parse(response.body);
            io.sockets.emit('top2', data);
        }, function (err) {
          console.log(err);
        });
}
function updateHistory() {
  requestify.post('http://localhost/api/getHistory', {})
        .then(function (response) {
            data = JSON.parse(response.body);
            io.sockets.emit('hist', data);
        }, function (err) {
  console.log(err);
        });
}
function getBalance(data){
  requestify.post('http://localhost/getBalance', {
    logina: data.user
  })
        .then(function (response) {
            data2 = JSON.parse(response.body);
            if(data2.status == 'true'){
                  io.sockets.emit('updateBalance',{logse: data.user, balance: data2.balalaika});
            }else{
              console.log(data2);
            }
        }, function (err) {
          console.log(err);
        });
}

function updateStatus() {
  requestify.post('http://localhost/api/stats', {})
        .then(function (response) {
            data = JSON.parse(response.body);
            var online = Object.keys(io.sockets.adapter.rooms).length;
            var total = data.total;
            var games = data.games;
            var data = [online, total, games];
            io.sockets.emit('statbox33', data);
        }, function (err) {
  console.log(err);
        });
}

function jet() {
    setTimeout(function () {
        requestify.post('http://localhost/api/last_drop_jet', {})
            .then(function (response) {
                data = JSON.parse(response.body);
                io.sockets.emit('last gifts jet', data.last_drop);
                console.log("Jet hist");
            }, function (err) {
  console.log(err);
            });
    }, 1);
}

io.sockets.on('last gift set jet', function () {
    setTimeout(function () {
        requestify.post('http://localhost/api/last_jet_get', {})
            .then(function (response) {
                data = JSON.parse(response.body);
                io.sockets.emit('last gift get jet', data);
                console.log("ok");
            }, function (err) {
                console.log(err);
            });
    }, 500);
});
