// Create an immediately invoked functional expression to wrap our code
(function () {
    // Define our constructor
    this.HOffine = function () {

        // Create global element references
        this.options = {};

        // Define option defaults
        var defaults = {
            // selector details
            imgurl: "../images/dot.png",
            selectorTag: "span",
            selectorNewId: "currentInternetStatus",
            getStatusOnTimeInterval: 5000,
            selectorToAppend: "body"
        }

        var tagToUpdate = '';
        var tagSelector = {};
        var status = {};
        var interval = null;

        // Public Methods

        HOffine.prototype.getStatus = function () {
            testConn();
        }

        HOffine.prototype.stopTesting = function () {
            clearInterval(interval);
        }

        // private methods

        // Create options by extending defaults with the passed in arugments
        function updateThisOptionsObject() {
            if (arguments[0] && typeof arguments[0] === "object") {
                var args = arguments[0];
                for (var arg in arguments[0]) {
                    if (args.hasOwnProperty(arg) && defaults.hasOwnProperty(arg)) {
                        defaults[arg] = args[arg];
                    }
                }
            }
            this.options = defaults;
        }

        function buildAppendToString() {
            if (!this.options.selectorTag && this.options.selectorTag.length <= 0) {
                return false;
            }
            tagToUpdate = "<" + options.selectorTag + " id='" + options.selectorNewId + "'>";
            tagToUpdate += "</" + options.selectorTag + ">";
            $(options.selectorToAppend).append(tagToUpdate);
            tagSelector = $("#" + options.selectorNewId);
        }

        function beginTestingInternet() {
            testConn();
            interval = setInterval(function () {
                testConn();
            }, this.options.getStatusOnTimeInterval);
        }

        function testConn() {
            jQuery.ajaxSetup({
                async: false
            });
            re = "";
            r = Math.round(Math.random() * 1000);
            
            $.get(options.imgurl, {
                subins: r
            }, function (d) {
                re = true;
                tagSelector.html('online');
            }).error(function (data, textStatus, xhr) {
                debugger
                re = false;
                tagSelector.html('offline');
            });
            return re;
        }

        function init() {
            updateThisOptionsObject();
            buildAppendToString();
            beginTestingInternet();
        }

        init();
    };
}());
