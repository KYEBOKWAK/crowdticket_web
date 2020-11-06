import States from "../States";

const Storage = {
  // save: (key, value, callback) => {
  save: (key, value, callback) => {
    const storagePromise = new Promise(function(resolve, reject){
      localStorage.setItem(key, value);
      resolve({
        state: States.Storage.success,
        mesage: ''
      });
    });

    storagePromise.then(function(value) {
      callback({
        ...value
      })
    }).catch(function(error){
      callback({
        ...error
      })
    });
  },
  load: (key, callback) => {
    const storagePromise = new Promise(function(resolve, reject){
      const result = localStorage.getItem(key);

      if(result){
        resolve({
          state: States.Storage.success,
          value: result,
          message: ''
        });
      }else{
        reject({
          // state: 'error',
          state: States.Storage.no_value,
          message: 'notValue'
        });
      }

      /*
      AsyncStorage.getItem(key, (error, result) => {
        if(result === null){
          if(error === null){
            reject({
              // state: 'error',
              state: States.Storage.no_value,
              message: 'notValue'
            });
          }else{
            reject({
              // state: 'error',
              state: States.Storage.error,
              message: error
            });
          }
          
        }else{
          resolve({
            state: States.Storage.success,
            value: result,
            message: ''
          });
        }
      });
      */
    });

    storagePromise.then(function(value) {
      return callback({
        ...value
      })
    }).catch(function(error){
      return callback({
        ...error
      })
    });
  },
  delete: (key, callback) => {
    const storagePromise = new Promise(function(resolve, reject){
      localStorage.removeItem(key);
      resolve({
        // state: 'success',
        state: States.Storage.success,
        message: ''
      });
    });

    storagePromise.then(function(value) {
      callback({
        ...value
      })
    }).catch(function(error){
      callback({
        ...error
      })
    });
  },

  clear: (callback) => {
    // clear(callback?: (error?: Error) => void)
    const storagePromise = new Promise(function(resolve, reject){
      localStorage.clear();
      resolve({
        state: States.Storage.success,
        message: ''
      });
    });

    storagePromise.then(function(value) {
      callback({
        ...value
      })
    }).catch(function(error){
      callback({
        ...error
      })
    });
  }
}

export default Storage;