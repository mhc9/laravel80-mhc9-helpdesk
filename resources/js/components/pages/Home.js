import React from 'react'
import SlideHeros from '../SlideHeros'
import OptionMenu from '../OptionMenu'
import SlideLogos from '../SlideLogos'
import Director from '../shared/Director'
import VideoList from '../Video/List'
import NewsList from '../News/List'
import PostList from '../Post/List'

const Home = () => {
    return (
        <>
            <SlideHeros />

            <OptionMenu />

            <section className="home">
                <div className="home-contents">
                    <div>
                        <div className="container">
                            <div className="row">
                                <div className="col-md-9">
                                    <PostList />
                                </div>
                                <div className="col-md-3">
                                    <Director />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style={{ background: '#D8D8D8' }}>
                        <div className="container">
                            <div className="row">
                                <div className="col-md-9">
                                    <VideoList />
                                </div>
                                <div className="col-md-3" style={{ background: '#ffffff' }}>
                                    <div className="link-box">
                                        <h1 className="title">สำหรับเจ้าหน้าที่</h1>

                                        <hr className="my-2" />

                                        <div className="link-items">
                                            <a href=""><i class="fas fa-coins"></i><h4>โปรแกรม WPM</h4></a>
                                            <a href=""><i class="fas fa-envelope-open-text"></i><h4>ระบบงานสารบรรณอิเล็กทรอนิกส์</h4></a>
                                            <a href=""><i class="fas fa-users"></i><h4>ระบบงานบุคลากร</h4></a>
                                            <a href=""><i class="far fa-credit-card"></i><h4>ระบบ E-Pay slip</h4></a>
                                            <a href=""><i class="fas fa-cogs"></i><h4>ระบบเพิ่มประสิทธิภาพการจัดการงบประมาณและแผนงาน (B&P DMH)</h4></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style={{ background: '#f3e2a9' }}>
                        <div className="container">
                            <div className="row">
                                <div className="col">
                                    <NewsList />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style={{ background: '#F2F2F2' }}>
                        <div className="container">
                            <div className="row">
                                <div className="col">
                                    <div className="info-box">
                                        <h1 className="title">Infographics</h1>

                                        <hr className="my-2" />

                                        <div className="row" style={{ padding: '0 1rem' }}>
                                            {[1,2,3,4].map((item, index) => (
                                                <div className="col-md-3 info-item">
                                                    <img src="./img/info-01.jpg" alt="info-pic" />
                                                </div>
                                            ))}
                                        </div>

                                        <div style={{ textAlign: 'center', margin: '1rem 0' }}>
                                            <a href="#" className="all-news">ทั้งหมด <i class="fas fa-angle-double-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <SlideLogos />
        </>
    )
}

export default Home