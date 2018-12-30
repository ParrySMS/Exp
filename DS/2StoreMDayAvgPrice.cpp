#include <iostream>
#include <algorithm>
#include <string>
 
using namespace std;
 
class stock{
public:
    string date;
    int days;
    string type;
    int s1;
    int s2;
    stock(){
        days=0;
    }
};
 
bool Compare(stock a,stock b){
    return a.days<b.days;
}
 
class stockbox{
    stock open[1000];
    stock closed[1000];
    int num;
    int open_num;
    int closed_num;
    int M;
public:
    stockbox(int _num,int _M){
        string _date,_type;
        int _s1,_s2,i;
        num=_num;
        M=_M;
        open_num=0;
        closed_num=0;
        for(i=0;i<num;i++){
            cin>>_date>>_type>>_s1>>_s2;
            if(_type=="open"){
                open[open_num].date=_date;
                open[open_num].type=_type;
                open[open_num].s1=_s1;
                open[open_num].s2=_s2;
                open[open_num].days=Transfrom_date(_date);
                open_num++;
            }
            else{
                closed[closed_num].date=_date;
                closed[closed_num].type=_type;
                closed[closed_num].s1=_s1;
                closed[closed_num].s2=_s2;
                closed[closed_num].days=Transfrom_date(_date);
                closed_num++;
            }
        }
    }
 
    int Transfrom_date(string s){
        int i,year,month,day,tmp1,tmp2,tmp3,days=0;
        string syear,smonth,sday;
        tmp1=s.find('/',0);
        syear=s.substr(0,tmp1);
        tmp2=s.find('/',tmp1+1);
        smonth=s.substr(tmp1+1,tmp2-tmp1-1);
        tmp3=s.find('/',tmp2+1);
        sday=s.substr(tmp2+1,tmp3-tmp2-1);
        year=(syear[0]-48)*1000+(syear[1]-48)*100+(syear[2]-48)*10+(syear[3]-48);
        if(smonth.size()==2)
            month=(smonth[0]-48)*10+(smonth[1]-48);
        else
            month=smonth[0]-48;
        if(sday.size()==2)
            day=(sday[0]-48)*10+(sday[1]-48);
        else
            day=sday[0]-48;
 
        //year
        for(i=1;i<year;i++){
            if((i%4==0 && i%100!=0) || (i%400 == 0))
                days+=366;
            else
                days+=365;
        }
 
        //month
        for(i=1;i<month;i++){
            switch(i){
                case 1:
                    days+=31;
                    break;
                case 2:
                    if((year%4==0 && year%100!=0) || (year%400 == 0))
                        days+=28;
                    else
                        days+=29;
                case 3:
                    days+=31;
                    break;
                case 4:
                    days+=30;
                    break;
                case 5:
                    days+=31;
                    break;
                case 6:
                    days+=30;
                    break;
                case 7:
                    days+=31;
                    break;
                case 8:
                    days+=31;
                    break;
                case 9:
                    days+=30;
                    break;
                case 10:
                    days+=31;
                    break;
                case 11:
                    days+=30;
                    break;
                case 12:
                    days+=31;
                    break;
            }
        }
 
        //day
        days+=day;
        return days;
    }
 
    void display(){
        int i,j,tmp1,tmp2;
        sort(open,open+open_num,Compare);
        sort(closed,closed+closed_num,Compare);
        for(i=M-1;i<open_num;i++){
            tmp1=0;
            tmp2=0;
            for(j=i-M+1;j<=i;j++){
                tmp1+=open[j].s1;
                tmp2+=open[j].s2;
            }
            tmp1=tmp1/M;
            tmp2=tmp2/M;
            cout<<open[i].date<<" "<<open[i].type<<" "<<tmp1<<" "<<tmp2<<endl;
        }
 
        for(i=M-1;i<closed_num;i++){
            tmp1=0;
            tmp2=0;
            for(j=i-M+1;j<=i;j++){
                tmp1+=closed[j].s1;
                tmp2+=closed[j].s2;
            }
            tmp1=tmp1/M;
            tmp2=tmp2/M;
            cout<<closed[i].date<<" "<<closed[i].type<<" "<<tmp1<<" "<<tmp2<<endl;
        }
    }
};
 
int main(){
 
    int N,M;
    while(cin>>N>>M){
        stockbox sbox(N,M);
        sbox.display();
    }
 
    return 0;
}
