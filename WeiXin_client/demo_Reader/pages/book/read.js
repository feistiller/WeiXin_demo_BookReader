// pages/book/read.js
var temp_data;
var temp_options;
Page({
  data: {},
  onLoad: function (options) {
    temp_options = options
    // 页面初始化 options为页面跳转所带来的参数
    console.log(wx.getStorageSync('usertoken'))
    if (wx.getStorageSync('usertoken') == '') {
      wx.navigateTo({
        url: './login'
      })
    } else {
      wx.request({
        //下一页或者初始化
        url: 'http://localhost:8000/API/nextPage', //仅为示例，并非真实的接口地址
        data: {
          'token': wx.getStorageSync('usertoken'),
          'bookId': options.id
        },
        method: 'POST',
        header: {
          'content-type': 'application/x-www-form-urlencoded'
        },
        success: function (res) {
          console.log(res.data.data[0])
          if (res.data.status == 1) {
            console.log(res.data.data)
            temp_data = res.data.data
          } else {
            wx.showToast({
              title: res.data.message,
              icon: 'loading',
              duration: 1000
            })
          }
        }
      })
    }
  },
  onReady: function () {
    // 页面渲染完成
    this.setData({
      items: temp_data
    })
  },
  onShow: function () {
    // 页面显示
  },
  onHide: function () {
    // 页面隐藏
  },
  onUnload: function () {
    // 页面关闭
  },
  beforePage: function (e) {
    wx.request({
      //上一页
      url: 'http://localhost:8000/API/beforePage', //仅为示例，并非真实的接口地址
      data: {
        'token': wx.getStorageSync('usertoken'),
        'bookId': temp_options.id
      },
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log(res.data.data[0])
        if (res.data.status == 1) {
          console.log(res.data.data)
          temp_data = res.data.data

        } else {
          wx.showToast({
            title: res.data.message,
            icon: 'loading',
            duration: 1000
          })
        }
      }
    })
    this.setData({
      items: temp_data
    })
  },
  nextPage: function (e) {
    wx.request({
      //下一页或者初始化
      url: 'http://localhost:8000/API/nextPage', //仅为示例，并非真实的接口地址
      data: {
        'token': wx.getStorageSync('usertoken'),
        'bookId': temp_options.id
      },
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log(res.data.data[0])
        if (res.data.status == 1) {
          console.log(res.data.data)
          temp_data = res.data.data

        } else {
          wx.showToast({
            title: res.data.message,
            icon: 'loading',
            duration: 1000
          })
        }
      }
    })
    this.setData({
      items: temp_data
    })
  }
})