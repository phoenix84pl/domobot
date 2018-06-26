# Menu do tft

import PIL
from PIL import Image
import os.path
import subprocess

class menu():

	def __init__(self, screen, screenResolution=(240, 320), tiles=(2, 3), background="black", gap=4):
		self._screen=screen						#TFT screen object
		self._screenResolution=screenResolution	#screenResolution in pixels
		self._tiles=tiles						#screen resoluion in tiles
		self._background=background
		self._gap=gap
		#docelowo jeszcze jeszcze moze byc ilosc ekranow menu

			#zmienne klasowe
		self._buttons=[]						#lista buttonow w menu

			#funkcje startowe
		self._mapCreate=self._mapCreate()
		self._tileSize=self._tileSizeCount()	#wyliczenie boku kafelka i marginesow

	def _mapCreate(self):
			#generowanie mapy
		self._map=[]
		for ix in range(self._tiles[0]):
			row=[]
			for iy in range(self._tiles[1]):
				row.append(None)
			self._map.append(row)

	def _mapFind(self, size):
			#szukanie miejsca na guzik
		for y in range(self._tiles[1]):			#dla kazdej kolumny
			for x in range(self._tiles[0]):		#dla kazdego rzedu
				wolne=0							#zliczamy ilosc wolnych pol, jesli okaze sie, ze jest ich w*h, to znaczy ze jest miejsce na caly guzik
				zajete=0
				for w in range(size[0]):		#dla kazdej szerokosci
					for h in range(size[1]):	#dla kazdej wysokosci
						if len(self._map)>x+w and len(self._map[x+w])>y+h and self._map[x+w][y+h]==None:	#jesli mapa ma wystarczajaca wielkosc i do tego sprawdzane pole jest puste to zaznacz, ze jest puste
							wolne+=1
						else:			#jesli mapa sie skonczyla lub zajete, to olej temat, badaj nastepna mozliwosc
							zajete+=1
							break
					if zajete>0:		#jesli znalazlo zajety w poprzednim rzedzie, to nastepnego juz nie sprawdzaj, idz od razu do nastepnego pola
						break
				if wolne==size[0]*size[1]:		#jesli wolne==potrzebne to zwroc adres pierwszego porzebnego pola
					return(x, y)

	def _mapLock(self, address, size, id):
			#blokowanie miejsca na guzik na mapie
		for w in range(size[0]):			#dla szerokosc
			for h in range(size[1]):		#dla wysokosci
				self._map[address[0]+w][address[1]+h]=id	#wpisz id buttona w mape

	def _tileSizeCount(self):
			#wyliczanie boku kafelka i marginesow (margin ma format [gora, dol, lewo, prawo])

		x=(self._screenResolution[0]-((self._tiles[0]+1)*self._gap))/self._tiles[0]
		y=(self._screenResolution[1]-((self._tiles[1]+1)*self._gap))/self._tiles[1]
		#return x<y and x or y	#mniejsza z wartosci #genialne, ale uzyjemy zwyklego if

		if x<y:
			margin=(self._screenResolution[1]-(x*self._tiles[1]+self._gap*(self._tiles[1]+1)))/2
			self._margin=(margin, margin, 0, 0)
			return x
		else:
			margin=(self._screenResolution[0]-(y*self._tiles[0]+self._gap*(self._tiles[0]+1)))/2
			self._margin=(0, 0, margin, margin)
			return y

	def _touch2button(self, pos):
			#zamienia pos na id buttona
		for i0 in range(len(self._buttons)):
			if self._buttons[i0]["position"][0]<=pos[0]<=self._buttons[i0]["position"][2] and self._buttons[i0]["position"][1]<=pos[1]<=self._buttons[i0]["position"][3]: return i0

	def buttonAdd(self, size=[1, 1], title=None, img=None, background=None):
			#dodanie buttona do listy

		address=self._mapFind(size)
		if address:
			id=len(self._buttons)

			dimensions=[size[0]*self._tileSize+(size[0]-1)*self._gap, size[1]*self._tileSize+(size[1]-1)*self._gap]	#wymiaty w px

			position=[]
			position.append(self._margin[2]+self._gap*(address[0]+1)+address[0]*self._tileSize)	#x gl
			position.append(self._margin[0]+self._gap*(address[1]+1)+address[1]*self._tileSize)	#y gl
			position.append(position[0]+dimensions[0])											#x dp
			position.append(position[1]+dimensions[1])											#x dl

			self._buttons.append({"size": size, "dimensions": dimensions, "title": title, "img": img, "background": background, "address": address, "position": position})
			self._mapLock(address, size, id)

			#dodac sprawdzanie na mapie buttonow wolnego miejsca i jego blokade
			#dodac wpisanie adresu z mapy do definicji buttona

	def show(self):
			#pokazanie menu na ekranie

			#siatka
		if True:
			for ix in range(self._tiles[0]):
				for iy in range(self._tiles[1]):
					x=self._margin[2]+self._gap*(ix+1)+ix*self._tileSize
					y=self._margin[0]+self._gap*(iy+1)+iy*self._tileSize
					self._screen.draw().rect((x, y, x+self._tileSize, y+self._tileSize))

			#fill
		if True:
			for i0 in range(len(self._buttons)):
				self._screen.draw().rect(self._buttons[i0]["position"], fill=self._buttons[i0]["background"])

			#obrazki
		if True:
			for i0 in range(len(self._buttons)):
				if self._buttons[i0]["img"]:
					if os.path.isfile(self._buttons[i0]["img"]):
						image=Image.open(self._buttons[i0]["img"])
						image=image.resize(self._buttons[i0]["dimensions"])
						self._screen.draw().pasteimage(image, (self._buttons[i0]["position"][0], self._buttons[i0]["position"][1]))

			#maluj menu
		self._screen.display()

	def touch(self, pos):
			#reaguje na dotyk
		id=self._touch2button(pos)
		if id!=None:	#bo moze byc 0
				#jesli dotknieto ktoregos guzika
			return_code=subprocess.call(('espeak -vpl "Siema"'), shell=True)

class tile():
	def __init__(self, size=(1, 1), background=None, picture=None, title=None):
		self._size=size
		self._background=background
