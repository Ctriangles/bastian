import { useEffect } from 'react';
import Masonry from 'react-masonry-css';
import img1 from "../assets/grid-img2/img1.png";
import img2 from "../assets/grid-img2/img2.png";
import img3 from "../assets/grid-img2/img3.png";
import img4 from "../assets/grid-img2/img4.png";
import img5 from "../assets/grid-img2/img6.png";
import img6 from "../assets/grid-img2/img5.png";
import img7 from "../assets/grid-img2/img7.png";
import img8 from "../assets/grid-img2/img8.png";
import img9 from "../assets/grid-img2/img9.png";
import img10 from "../assets/grid-img2/img10.png";
import img11 from "../assets/grid-img2/img11.png";
import img12 from "../assets/grid-img2/img12.png";
import img13 from "../assets/grid-img2/img13.png";
import img14 from "../assets/grid-img2/img14.png";
import img15 from "../assets/grid-img2/img15.png";
import img16 from "../assets/grid-img2/img16.png";
import img17 from "../assets/grid-img2/img17.png";
import img18 from "../assets/grid-img2/img18.png";
import img19 from "../assets/grid-img2/img19.png";
import img20 from "../assets/grid-img2/img20.png";

const MasonryLayout = () => {
    const items = [
        { id: 1, src: img1, title: 'Image 1' },
        { id: 2, src: img2, title: 'Image 2' },
        { id: 3, src: img3, title: 'Image 3' },
        { id: 4, src: img4, title: 'Image 4' },
        { id: 5, src: img5, title: 'Image 5' },
        { id: 6, src: img6, title: 'Image 6' },
        { id: 7, src: img7, title: 'Image 7' },
        { id: 8, src: img8, title: 'Image 8' },
        { id: 9, src: img9, title: 'Image 9' },
        { id: 10, src: img10, title: 'Image 10' },
        { id: 11, src: img11, title: 'Image 11' },
        { id: 12, src: img12, title: 'Image 12' },
        { id: 13, src: img13, title: 'Image 13' },
        { id: 14, src: img14, title: 'Image 14' },
        { id: 15, src: img15, title: 'Image 15' },
        { id: 16, src: img16, title: 'Image 16' },
        { id: 17, src: img17, title: 'Image 17' },
        { id: 18, src: img18, title: 'Image 18' },
        { id: 19, src: img19, title: 'Image 19' },
        { id: 20, src: img20, title: 'Image 20' },
    ];

    const breakpointColumnsObj = {
        default: 3,
        1100: 3,
        700: 2,
        500: 1
    };

    return (
        <Masonry
            breakpointCols={breakpointColumnsObj}
            className="masonry-grid px-7"
            columnClassName="masonry-grid_column"
        >
            {items.map((item) => (
                <div key={item.id} className="masonry-item">
                    <img src={item.src} alt={item.title} className="masonry-image" />
                </div>
            ))}
        </Masonry>
    );
};

export default MasonryLayout;
