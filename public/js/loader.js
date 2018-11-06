(function() {

	var Loader = function(segment, take) {
		var mSegment = segment;
		var mSkip = 0;
		var mTake = take ? take : 20;
		var mParams = {};
		var mTemplate;
		var mContainer;
		var mLoading = false;
		var mNothingToLoad = false;
		var mLoadedListener;
		var mCompleteListener;
		var mErrorListener;

		this.addParam = function(key, value) {
			mParams[key] = value;
		};

		this.setTemplate = function(templateId) {
			var template = $(templateId).html();
			mTemplate = _.template(template);
		};

		this.setContainer = function(containerId) {
			mContainer = $(containerId);
		};

		this.setLoadedListener = function(l) {
			mLoadedListener = l;
		};

		this.setCompleteListener = function(l) {
			mCompleteListener = l;
		};

		this.setErrorListener = function(l) {
			mErrorListener = l;
		};

		this.load = function() {
			if (mNothingToLoad) {
				return;
			}

			if (mLoading) {
				return;
			}

			mLoading = true;

			var url = mSegment;
			url += "?skip=" + mSkip;
			url += "&take=" + mTake;
			$.each(mParams, function(key, value) {
				url += "&" + key + "=" + value;
			});

			var method = "get";
			var success = function(result) {
				if (!mTemplate || !mContainer) {
					return;
				}

				for (var i = 0, l = result.length; i < l; i++) {
					var row = mTemplate({ "data": result[i] });
					mContainer.append(row);
				}

				if (mLoadedListener) {
					mLoadedListener();
				}

				var loaded = result.length;
				//if (loaded < mTake) {	//원인 모를 코드. take값 때문에 listener가 동작을 안함(댓글의 댓글달기)
					mNothingToLoad = true;
					if (mCompleteListener) {
						mCompleteListener();
					}
				//}
				mSkip += loaded;
				mLoading = false;
			};

			var error = function() {
				if (mErrorListener) {
					mErrorListener();
				}
				mLoading = false;
			};

			$.ajax({
				"url": url,
				"method": method,
				"success": success,
				"error": error
			});
		};
	};

	window.Loader = Loader;
})();
