<?php

use App\HashTag;
use Illuminate\Database\Seeder;

class HashTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $groups = "인문사회대학 IT대학 경상대학 체육의료복지대학 융합과학대학 미술대학 공과대학 음악대학 공연영상학부";
        $groups = explode(" ", $groups);

        foreach ($groups as $group) {
            $newhash = new HashTag();
            $newhash->tag = "수원대학교".$group;
            $newhash->picture = '/image/default.png';
            $newhash->save();
        }

        $majors = "경제금융학과@경영학과@회계학과@무역학과@호텔관광경영학과@인문대학@국어국문학과@러시아학@연극영화과@영어영문학과@중국어학과@사학과@일본어학과@프랑스어학과@연기연출@법학과@행정학과@언론정보학과@자연과학대학@수학과@화학과@물리학과@통계정보학과@생명과학과@생명공학과@간호학과@토목공학과@건축공학과@기계공학과@전자공학과@도시부동산개발학과@화공생명공학과@환경공학과@산업정보공학과@신소재공학과@전자재료공학과@전기공학과@컴퓨터학과@정보통신공학과@정보보호학과@정보미디어학과@생활과학대학@아동가족복지학과@의류학과@식품영양학과@체육학과@사회체육학과@무용학과@무도체육학과@동양화과@커뮤니케이션디자인@서양화과@패션디자인과@조소과@공예디자인과@음악대학@관현악과@작곡과@성악과@국악과@피아노과";
        $majors = explode("@", $majors);

        foreach ($majors as $major) {
            $newhash = new HashTag();
            $newhash->tag = "수원대학교".$major;
            $newhash->picture = '/image/default.png';
            $newhash->save();
        }



        $newhash = new HashTag();
        $newhash->tag = "프리미디어";
        $newhash->picture = '/image/default.png';
        $newhash->save();
        $newhash = new HashTag();
        $newhash->tag = "수원대학교";
        $newhash->picture = '/image/default.png';
        $newhash->save();
        $newhash = new HashTag();
        $newhash->tag = "우리회사";
        $newhash->picture = '/image/default.png';
        $newhash->save();
        $newhash = new HashTag();
        $newhash->tag = "컴퓨터학과";
        $newhash->picture = '/image/default.png';
        $newhash->save();
    }
}
