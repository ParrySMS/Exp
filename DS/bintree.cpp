#include <iostream>
#include <string>
using namespace std;

class BinTreeNode {
	public:
		char data;
		BinTreeNode *left;
		BinTreeNode *right;
		BinTreeNode () {
			left = NULL;
			right = NULL;
		}
		~BinTreeNode();
};


class BinTree {
	private:
		BinTreeNode* root;
		int pos;
		string strTree;
		BinTreeNode * CreateBinTree();
		void PreOrder(BinTreeNode *t);
		void InOrder(BinTreeNode *t);
		void PostOrder(BinTreeNode *t);


	public:
		BinTree() {};
		~BinTree() {};
		void CreateTree(string TreeAr);
		void PreOrder();//前序
		void InOrder();//中序
		void PostOrder();//后序
		bool isVaildCh(char ch);
		void setRoot(BinTreeNode* node);

};

void BinTree::setRoot(BinTreeNode* node) {
	root = node;
}

bool BinTree::isVaildCh(char ch) {
	return ch!='0' && ch!='\0';
}

// use PreOrder string to build a tree
void BinTree::CreateTree(string TreeAr) {
	pos = 0;
	strTree.assign(TreeAr);
	root = CreateBinTree();

}


//fill the node by recursion
// PreOrder string
BinTreeNode* BinTree::CreateBinTree() {
	BinTreeNode* t;
	char ch;
	ch = strTree[pos++];//next char
//	cout<<"ch:"<<ch<<endl;

	if(!isVaildCh(ch)) {
		t = NULL;
	} else {
		//	cout<<"new tree node";
		t = new BinTreeNode();
		t->data = ch;
		t->left = CreateBinTree();
		t->right = CreateBinTree();
	}

	return t;
}


//public 先序
void BinTree::PreOrder() {
	PreOrder(root);
	cout<<endl;
}

//private 先序
void BinTree::PreOrder(BinTreeNode *t) {
	if(t!=NULL && isVaildCh(t->data)) {
		cout<<t->data;
		PreOrder(t->left);
		PreOrder(t->right);
	}
}


//public 中序
void BinTree::InOrder() {
	InOrder(root);
	cout<<endl;
}

//private 中序
void BinTree::InOrder(BinTreeNode *t) {

	if(t!=NULL && isVaildCh(t->data)) {
		InOrder(t->left);
		cout<<t->data;
		InOrder(t->right);
	}
}

//public 后序
void BinTree::PostOrder() {
	PostOrder(root);
	cout<<endl;
}

//private 后序
void BinTree::PostOrder(BinTreeNode *t) {

	if(t!=NULL && isVaildCh(t->data)) {
		PostOrder(t->left);
		PostOrder(t->right);
		cout<<t->data;
	}
}


int main() {
	int t;
	string str;
	BinTree * bin;
	cin>>t;

	while(t--) {

		cin>>str;

		bin = new BinTree();
		bin->CreateTree(str);

		bin->PreOrder();
		bin->InOrder();
		bin->PostOrder();



	}


	return 0;
}









