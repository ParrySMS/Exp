#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;

class Point {
		int x,y,z;

	public :

		int getX() {
			return x;
		}

		int getY() {
			return y;
		}

		int getZ() {
			return z;
		}

		Point(Point &p) {
			x = p.getX();
			y = p.getY();
			z = p.getZ();
		}
		Point(int _x = 0,int _y =0,int _z =0) {
			x = _x;
			y = _y;
			z = _z;
		}

		void init(Point &p) {
			x = p.getX();
			y = p.getY();
			z = p.getZ();
		}
		void add() {
			x++;
			y++;
			z++;

		}

		void sub() {
			x--;
			y--;
			z--;

		}
		friend Point operator ++(Point &a);
		friend Point operator ++(Point &a,int);
		friend Point operator --(Point &a);
		friend Point operator --(Point &a,int);

		void show() {

			cout<<"x="<<x<<" ";
			cout<<"y="<<y<<" ";
			cout<<"z="<<z<<endl;
		}

		void show(Point &p) {
			cout<<"x="<<p.getX()<<" ";
			cout<<"y="<<p.getY()<<" ";
			cout<<"z="<<p.getZ()<<endl;
		}


};


Point operator++(Point &a,int) {
	a.add();
}

Point operator++(Point &a) {
	Point p2(a);
	p2.add();
	return p2;
}

Point operator--(Point &a,int) {
	a.sub();
}

Point operator--(Point &a) {
	Point p2(a);
	p2.sub();
	return p2;
}

int main() {
	int x,y,z,i;
	cin>>x>>y>>z;
	Point p(x,y,z);
	Point p_copy(p);

	p++;
	p.show();

	p.init(p_copy);
	p_copy.init(p);
	p_copy.show();

	p.init(p_copy);
	p = ++p;
	p.show(p);
	p.show();

	p.init(p_copy);
	p--;
	p.show(p);
	p.show(p_copy);

	p.init(p_copy);
	p = --p;
	p.show(p);
	p.show();



	return 0 ;
}

