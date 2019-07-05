#include<iostream>
using namespace std;
class Point3D;
class RMB {
		int yuan,jiao,fen;
	public:
		RMB(int y=0,int j=0,int f=0);
		operator double();
		operator int();
		operator Point3D();
		void print();
};
class Point3D {
		double x,y,z;
	public:
		Point3D(double _x=0,double _y=0,double _z=0);
		void print();
		operator RMB();
};
RMB::RMB(int y,int j,int f):yuan(y),jiao(j),fen(f) {}
RMB::operator double() {
	return yuan+jiao/10.0+fen/100.0;
}
RMB::operator int() {
	return yuan*100+jiao*10+fen;
}
RMB::operator Point3D() {
	return Point3D(yuan,jiao,fen);
}
void RMB::print() {
	cout<<yuan<<"."<<jiao<<fen<<endl;
}

Point3D::Point3D(double _x,double _y,double _z):x(_x),y(_y),z(_z) {}
void Point3D::print() {
	cout<<"("<<x<<","<<y<<","<<z<<")"<<endl;
}
Point3D::operator RMB() {
	return RMB(x,y,z);
}

int main() {

	RMB r(1,2,3);
	double d=r;
	cout<<d<<endl;

	int t=r;
	cout<<t<<endl;

	Point3D p=r;
	p.print();

	Point3D p1(2,3,4);
	RMB r1=p1;
	r1.print();
	return 1;
}

