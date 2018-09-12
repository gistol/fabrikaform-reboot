exports.preloadImg = function(path) {
  return new Promise(function(resolve, reject) {
    var image = new Image();
    image.onload = resolve;
    image.onerror = resolve;
    image.src = path;
  });
};
