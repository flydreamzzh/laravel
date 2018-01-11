'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

require('rc-tree-select/assets/index.css');

// require('./demo.less');

var _react = require('react');

var _react2 = _interopRequireDefault(_react);

var _reactDom = require('react-dom');

var _reactDom2 = _interopRequireDefault(_reactDom);

var _rcTreeSelect = require('rc-tree-select');

var _rcTreeSelect2 = _interopRequireDefault(_rcTreeSelect);

var _util = require('rc-tree-select/lib/util');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } } /* eslint react/no-multi-comp:0, no-console:0, no-alert: 0 */

function isLeaf(value) {
    if (!value) {
        return false;
    }
    var queues = [].concat(_toConsumableArray(_util.gData));
    while (queues.length) {
        // BFS
        var item = queues.shift();
        if (item.value === value) {
            if (!item.children) {
                return true;
            }
            return false;
        }
        if (item.children) {
            queues = queues.concat(item.children);
        }
    }
    return false;
}

function findPath(value, data) {
    var sel = [];
    function loop(selected, children) {
        for (var i = 0; i < children.length; i++) {
            var item = children[i];
            if (selected == item.value) {
                sel.push(item);
                return;
            }
            if (item.children) {
                loop(selected, item.children, item);
                if (sel.length) {
                    sel.push(item);
                    return;
                }
            }
        }
    }
    loop(value, data);
    return sel;
}

var treeData = (function () {
    var url = $("#treeSelectUrl").val();
    var data;
    $.ajax({
        url: url,
        method: 'get',
        async: false,
        success: function (response) {
            data = JSON.parse(response);
        }
    });
    return data;
})();

/**
 * @param treeValue 初始化值
 * @param treeLabel 初始化label
 */
var treeValue = $("#treeSelectValue").val();
var valueObj = { value: 'null', label: '上级节点，不选为顶级节点' };
if (treeValue) {
    var treeLabel = findPath(treeValue, treeData).map(function (i) { return i.label; }).reverse().join(' > ');
    valueObj = { value: treeValue, label: treeLabel };
}

var Demo = function (_React$Component) {
    _inherits(Demo, _React$Component);

    function Demo() {
        var _ref,
            _arguments = arguments;

        var _temp, _this, _ret;

        for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
            args[_key] = arguments[_key];
        }

        _classCallCheck(this, Demo);

        return _ret = (_temp = (_this = _possibleConstructorReturn(this, (_ref = Demo.__proto__ || Object.getPrototypeOf(Demo)).call.apply(_ref, [this].concat(args))), _this), _this.state = {
            tsOpen: false,
            visible: false,
            value: (function () {
                return treeValue;
            })(),
            // value: ['0-0-0-0-value', '0-0-0-1-value', '0-0-0-2-value'],
            lv: valueObj,
            multipleValue: [],
            simpleTreeData: [{ key: 1, pId: 0, label: 'test1', value: 'test1' }, { key: 121, pId: 0, label: 'test1', value: 'test121' }, { key: 11, pId: 1, label: 'test11', value: 'test11' }, { key: 12, pId: 1, label: 'test12', value: 'test12' }, { key: 111, pId: 11, label: 'test111', value: 'test111' }],
            treeDataSimpleMode: {
                id: 'key',
                rootPId: 0
            }
        }, _this.onClick = function () {
            _this.setState({
                visible: true
            });
        }, _this.onClose = function () {
            _this.setState({
                visible: false
            });
        }, _this.onSearch = function (value) {
            // console.log(value, _arguments);
        }, _this.onChange = function (value) {
            // console.log('onChange', _arguments);
            _this.setState({ value: value });
        }, _this.onChangeChildren = function (value) {
            // console.log('onChangeChildren', _arguments);
            var pre = value ? _this.state.value : undefined;
            _this.setState({ value: isLeaf(value) ? value : pre });
        }, _this.onChangeLV = function (value) {
            // console.log('labelInValue', _arguments);
            if (!value) {
                $("#treeSelectValue").val('');
                _this.setState({ lv: undefined });
                return;
            }
            var path = findPath(value.value, treeData).map(function (i) {
                return i.label;
            }).reverse().join(' > ');
            _this.setState({ lv: { value: value.value, label: path } });
            $("#treeSelectValue").val(value.value);
        }, _this.onMultipleChange = function (value) {
            // console.log('onMultipleChange', _arguments);
            _this.setState({ multipleValue: value });
        }, _this.onSelect = function () {
            // use onChange instead
            // console.log(_arguments);
        }, _this.onDropdownVisibleChange = function (visible, info) {
            // console.log(visible, _this.state.value, info);
            if (Array.isArray(_this.state.value) && _this.state.value.length > 1 && _this.state.value.length < 3) {
                alert('please select more than two item or less than one item.');
                return false;
            }
            return true;
        }, _this.filterTreeNode = function (input, child) {
            return String(child.props.title).indexOf(input)  !== -1;
        }, _temp), _possibleConstructorReturn(_this, _ret);
    }

    _createClass(Demo, [{
        key: 'componentDidMount',
        value: function componentDidMount() {
            // console.log(this.refs.mul.getInputDOMNode());
            // this.refs.mul.getInputDOMNode().setAttribute('disabled', true);
        }
    }, {
        key: 'render',
        value: function render() {
            return _react2.default.createElement(_rcTreeSelect2.default, {
                getPopupContainer: function getPopupContainer(triggerNode) {
                    return triggerNode.parentNode;
                },
                style: { width: '100%' },
                transitionName: 'rc-tree-select-dropdown-slide-up',
                choiceTransitionName: 'rc-tree-select-selection__choice-zoom',
                dropdownStyle: { maxHeight: 200, overflow: 'auto', zIndex: 1500 },
                placeholder: _react2.default.createElement(
                    'i',
                    null,
                    '上级节点，不选为顶级节点'
                ),
                searchPlaceholder: 'please search',
                showSearch: true, allowClear: true, treeLine: true,
                value: this.state.lv, labelInValue: true,
                treeData: treeData,
                className: 'treeSelect',
                treeNodeFilterProp: 'label',
                filterTreeNode: this.filterTreeNode,
                onSearch: this.onSearch,
                onChange: this.onChangeLV,
                onSelect: this.onSelect
            });
        }
    }]);

    return Demo;
}(_react2.default.Component);

_reactDom2.default.render(_react2.default.createElement(Demo, null), document.getElementById('__react-content'));