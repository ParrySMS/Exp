#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;

class CN; //提前声明
class EN; //提前声明
class Weight { //抽象类
	protected:
		char kind[20]; //计重类型
		int gram; //克
	public:
		char* getKind() {
			return kind;
		}
		Weight() {	}
		Weight (char tk[], int tg=0) {
			strcpy(kind, tk);
			gram = tg;
		}
		virtual void Print(ostream & out) = 0; //输出不同类型的计重信息
};

class EN: public Weight { //英国计重
		int pound,oz,dram;

	public:
		EN() {};
		EN(int p,int o,int d,int g,char tk[] ) {
			strcpy(kind, tk);
			gram = g;
			pound = p;
			oz = o;
			dram = d;
		};

		int countGram() {
			return pound*512 +oz*32+dram*2+gram;
		}
		void Convert(int g) {
			if(g>=512) {
				pound = g/512;
				g=g-pound*512;
			}

			if(g>=32) {
				oz = g/32;
				g=g-oz*32;
			}

			if(g>=2) {
				dram = g/2;
				g=g-dram*2;
			}
			gram = g;
		}

		void Print(ostream & cout) {
			cout<<kind<<":";
			cout<<pound<<"磅";
			cout<<oz<<"盎司";
			cout<<dram<<"打兰";
			cout<<gram<<"克"<<endl;
		}


};
class CN: public Weight { //中国计重
		int jin,liang,qian;

	public:
		CN() {};
		CN(int j,int l,int q,int g,char tk[] ) {
			strcpy(kind, tk);
			gram = g;
			jin = j;
			liang = l;
			qian = q;
		};

		void Convert(int g) {
			if(g>=500) {
				jin = g/500;
				g=g-jin*500;
			}

			if(g>=50) {
				liang = g/50;
				g=g-liang*50;
			}

			if(g>=5) {
				qian = g/5;
				g=g-qian*5;
			}
			gram = g;
		}

		void Print(ostream & cout) {
			cout<<kind<<":";
			cout<<jin<<"斤";
			cout<<liang<<"两";
			cout<<qian<<"钱";
			cout<<gram<<"克"<<endl;
		}

		void operator=(EN & en) {
			int g = en.countGram();
			Convert(g);
		}


};

//以全局函数方式重载输出运算符，代码3-5行....自行编写
void operator<<( ostream & os,Weight & w) {
	w.Print(os);
}


//重载函数包含两个参数：ostream流对象、Weight类对象，参数可以是对象或对象引用
//重载函数必须调用参数Weight对象的Print方法
int main() { //主函数
	int tw;
//创建一个中国计重类对象cn
//构造参数对应斤、两、钱、克、类型，其中克和类型是对应基类属性gram和kind
	char c1[] ="中国计重";
	CN cn(0,0,0,0, c1);
	cin>>tw;
	cn.Convert(tw); //把输入的克数转成中国计重
	cout<<cn;

//创建英国计重类对象en
//构造参数对应磅、盎司、打兰、克、类型，其中克和类型是对应基类属性gram和kind
	char c2[] ="英国计重";
	EN en(0,0,0,0,c2);
	cin>>tw;
	en.Convert(tw); //把输入的克数转成英国计重
	cout<<en;
	cn=en; //把英国计重转成中国计重
	cout<<cn;
	return 0;
}
