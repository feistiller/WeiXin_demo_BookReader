//index.js
//获取应用实例
var app = getApp()
var temp_data;
Page({
  data: {
    items:[]
  },
  onLoad: function (e) {
    console.log(1)
    //页面初始化后发出新的请求
    wx.request({
      url: 'http://localhost:8000/API', //仅为示例，并非真实的接口地址
      data: {
      },
      method: 'GET',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log(res.data.data)
        if (res.data.status == 1) {
          temp_data = res.data.data
        } else {
          wx.showToast({
            title: res.data.message,
            icon: 'loading',
            duration: 2000
          })
        }
      }
    })
  },
  onReady: function () {
    // 页面渲染完成
    this.setData({
      items:temp_data
    })
  },
})
